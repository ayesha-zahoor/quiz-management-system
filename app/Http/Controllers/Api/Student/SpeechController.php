<?php

namespace App\Http\Controllers\Api\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * Free Urdu voice, no account and no API key.
 *
 * It uses Google Translate's public web endpoints. These are NOT an official, supported API:
 * Google can change or block them at any time, so treat this as a free option for a school-sized
 * project, not something to depend on for high-stakes use. Everything is cached, so each text is
 * requested from Google only once.
 *
 * POST /api/student/speech   { "text": "...", "translate": true|false }
 *   translate = true  -> the text is translated into Urdu first
 * Returns { success, url (MP3), text (the Urdu text that was spoken) }
 */
class SpeechController extends Controller
{
    private const USER_AGENT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0 Safari/537.36';

    public function speak(Request $request)
    {
        $data = $request->validate([
            'text'      => 'required|string|max:1500',
            'translate' => 'sometimes|boolean',
        ]);

        $text = trim($data['text']);

        if (! empty($data['translate'])) {
            try {
                $text = $this->translateToUrdu($text);
            } catch (\Throwable $e) {
                 \Log::error("transaction failed". $e->getMessage(),[
                    'class'=>get_class($e),
                    'file'=>getFile().':'.$e->getLine(),
                 ]);
                // report($e);

                return response()->json(['success' => false, 'message' => 'Translation is unavailable right now.'], 502);
            }
        }

        $path = 'tts/' . md5('google-ur|' . $text) . '.mp3';

        if (! Storage::disk('public')->exists($path)) {
            try {
                Storage::disk('public')->put($path, $this->speechAudio($text));
            } catch (\Throwable $e) {
                report($e);

                return response()->json(['success' => false, 'message' => 'The Urdu voice is unavailable right now.'], 502);
            }
        }

        return response()->json([
            'success' => true,
            'url'     => '/storage/' . $path,
            'text'    => $text,
        ]);
    }

    // English -> Urdu text (cached forever, so each sentence is translated once)
    private function translateToUrdu(string $text): string
    {
        return Cache::rememberForever('translate_ur_' . md5($text), function () use ($text) {
            $response = Http::withHeaders(['User-Agent' => self::USER_AGENT])
                ->timeout(15)
                ->get('https://translate.googleapis.com/translate_a/single', [
                    'client' => 'gtx',
                    'sl'     => 'auto',
                    'tl'     => 'ur',
                    'dt'     => 't',
                    'q'      => $text,
                ]);

            $response->throw();

            // The answer is a nested list: [[ [translated, original, ...], ... ], ...]
            $translated = collect($response->json('0') ?? [])->pluck(0)->filter()->implode('');

            if ($translated === '') {
                throw new \RuntimeException('Empty translation.');
            }

            return $translated;
        });
    }

    // Urdu text -> MP3 bytes. Google reads about 200 characters per request, so long text is sent in pieces.
    private function speechAudio(string $text): string
    {
        $audio = '';

        foreach ($this->chunks($text) as $chunk) {
            $response = Http::withHeaders([
                    'User-Agent' => self::USER_AGENT,
                    'Referer'    => 'https://translate.google.com/',
                ])
                ->timeout(20)
                ->get('https://translate.google.com/translate_tts', [
                    'ie'      => 'UTF-8',
                    'client'  => 'tw-ob',
                    'tl'      => 'ur',
                    'q'       => $chunk,
                    'total'   => 1,
                    'idx'     => 0,
                    'textlen' => mb_strlen($chunk),
                ]);

            if ($response->failed() || $response->body() === '' || ! str_contains((string) $response->header('Content-Type'), 'audio')) {
                throw new \RuntimeException('The speech request failed.');
            }

            $audio .= $response->body();
        }

        return $audio;
    }

    // Splits text at sentence ends (and spaces if a sentence is very long) into pieces of at most $max characters
    private function chunks(string $text, int $max = 180): array
    {
        $text  = preg_replace('/\s+/u', ' ', trim($text));
        $parts = preg_split('/(?<=[۔.?؟!،,])\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);

        $pieces = [];
        foreach ($parts as $part) {
            while (mb_strlen($part) > $max) {
                $cut      = mb_strrpos(mb_substr($part, 0, $max), ' ') ?: $max;
                $pieces[] = trim(mb_substr($part, 0, $cut));
                $part     = trim(mb_substr($part, $cut));
            }

            if ($part !== '') {
                $pieces[] = $part;
            }
        }

        $chunks  = [];
        $current = '';
        foreach ($pieces as $piece) {
            if ($current !== '' && mb_strlen($current . ' ' . $piece) > $max) {
                $chunks[] = $current;
                $current  = $piece;
            } else {
                $current = $current === '' ? $piece : $current . ' ' . $piece;
            }
        }

        if ($current !== '') {
            $chunks[] = $current;
        }

        return $chunks;
    }
}