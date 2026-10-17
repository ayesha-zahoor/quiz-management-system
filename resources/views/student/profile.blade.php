{{-- resources/views/student/profile.blade.php --}}
@extends('layouts.student')

@section('title', 'My Profile')

@section('content')
<div class="student-content">
<div class="pf">

    <header class="pf-title">
        <h1>My profile</h1>
        <p>Manage how you appear in QuizSphere.</p>
    </header>

    <div class="pf-layout">

        {{-- ============ Student ID card ============ --}}
        <aside class="pf-id" aria-label="Student ID card">
            <div class="pf-id-top">
                <i class="bi bi-mortarboard-fill"></i>
                <span id="idInstitute">Your institute</span>
                <em>Student ID</em>
            </div>

            <div class="pf-id-body">
                <div class="pf-photo-wrap">
                    <div class="pf-photo">
                        <img id="pfAvatarImg" alt="Your profile picture" hidden>
                        <span id="pfAvatarText">ST</span>
                    </div>

                    <label class="pf-camera" for="pfPhoto" title="Change picture">
                        <i class="bi bi-camera-fill"></i>
                        <span class="visually-hidden">Change picture</span>
                    </label>
                </div>

                <h2 id="pfName">Your profile</h2>
                <div class="pf-chips" id="pfChips"></div>

                <dl class="pf-details">
                    <div><dt>Email</dt><dd id="dtEmail">-</dd></div>
                    <div><dt>Roll number</dt><dd id="dtRoll">-</dd></div>
                    <div><dt>Class</dt><dd id="dtClass">-</dd></div>
                    <div><dt>Member since</dt><dd id="dtSince">-</dd></div>
                </dl>

                <p class="pf-locked"><i class="bi bi-lock-fill"></i> These details are managed by your institute.</p>
            </div>
        </aside>

        {{-- ============ Right side ============ --}}
        <div class="pf-main">

            <section class="pf-stats" aria-label="My learning snapshot">
                <div class="pf-stat">
                    <span class="pf-stat-icon"><i class="bi bi-check2-circle"></i></span>
                    <div><b id="stCompleted">-</b><small>Quizzes finished</small></div>
                </div>
                <div class="pf-stat">
                    <span class="pf-stat-icon"><i class="bi bi-graph-up-arrow"></i></span>
                    <div><b id="stAverage">-</b><small>Average score</small></div>
                </div>
                <div class="pf-stat">
                    <span class="pf-stat-icon"><i class="bi bi-trophy"></i></span>
                    <div><b id="stBest">-</b><small>Best score</small></div>
                </div>
            </section>

            <section class="pf-card">

                <div class="pf-tabs" role="tablist" aria-label="Account settings">
                    <button type="button" role="tab" id="tabProfile" class="active" aria-selected="true" aria-controls="panelProfile">Profile</button>
                    <button type="button" role="tab" id="tabPassword" aria-selected="false" aria-controls="panelPassword" tabindex="-1">Password</button>
                </div>

                {{-- ---- Profile ---- --}}
                <div id="panelProfile" role="tabpanel" aria-labelledby="tabProfile">
                    <form id="profileForm" novalidate>
                        <label class="pf-label" for="pfNameInput">Your name</label>
                        <input type="text" id="pfNameInput" class="pf-input" maxlength="255" autocomplete="name" required>
                        <div class="pf-error" data-error="name"></div>

                        <div class="pf-label">Profile picture</div>
                        <div class="pf-photo-actions">
                            <label for="pfPhoto" class="pf-btn ghost"><i class="bi bi-upload"></i> <span id="pfPhotoLabel">Choose picture</span></label>
                            <button type="button" class="pf-btn link danger" id="pfPhotoRemove" hidden>Remove picture</button>
                        </div>
                        <input type="file" class="visually-hidden" id="pfPhoto" accept="image/png,image/jpeg,image/webp">
                        <div class="pf-help">JPG, PNG or WebP, up to 2 MB. It shows on your ID card.</div>
                        <div class="pf-note" id="pfPhotoNote" hidden></div>
                        <div class="pf-error" data-error="profile_image"></div>

                        <div class="pf-actions">
                            <button type="submit" class="pf-btn solid" id="pfSave" disabled>Save changes</button>
                            <button type="button" class="pf-btn link" id="pfReset" hidden>Undo changes</button>
                        </div>
                    </form>
                </div>

                {{-- ---- Password ---- --}}
                <div id="panelPassword" role="tabpanel" aria-labelledby="tabPassword" hidden>
                    <form id="passwordForm" novalidate>
                        <p class="pf-sub">You will stay signed in here. Your other devices will be signed out.</p>

                        <label class="pf-label" for="pwCurrent">Current password</label>
                        <div class="pf-pass">
                            <input type="password" id="pwCurrent" class="pf-input" autocomplete="current-password">
                            <button type="button" class="pf-eye" data-toggle="pwCurrent" aria-label="Show password"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="pf-error" data-error="current_password"></div>

                        <label class="pf-label" for="pwNew">New password</label>
                        <div class="pf-pass">
                            <input type="password" id="pwNew" class="pf-input" autocomplete="new-password">
                            <button type="button" class="pf-eye" data-toggle="pwNew" aria-label="Show password"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="pf-meter" aria-hidden="true"><div id="pwBar"></div></div>
                        <div class="pf-help" id="pwHint">At least 8 characters.</div>
                        <div class="pf-error" data-error="password"></div>

                        <label class="pf-label" for="pwConfirm">Confirm new password</label>
                        <div class="pf-pass">
                            <input type="password" id="pwConfirm" class="pf-input" autocomplete="new-password">
                            <button type="button" class="pf-eye" data-toggle="pwConfirm" aria-label="Show password"><i class="bi bi-eye"></i></button>
                        </div>
                        <div class="pf-error" data-error="password_confirmation"></div>

                        <div class="pf-actions">
                            <button type="submit" class="pf-btn solid" id="pwSave">Change password</button>
                        </div>
                    </form>
                </div>

            </section>
        </div>

    </div>
</div>
</div>

<div class="pf-toast" id="pfToast" role="status" aria-live="polite" hidden></div>
@endsection


@push('styles')
<style>
    [hidden] { display: none !important; }

    .pf { max-width: 1060px; margin: 0 auto; }

    .pf-title { margin-bottom: 24px; }
    .pf-title h1 { margin: 0 0 4px; font-size: clamp(26px, 3vw, 34px); font-weight: 800; }
    .pf-title p { margin: 0; color: var(--muted-color); }

    .pf-layout { display: grid; grid-template-columns: 340px minmax(0, 1fr); gap: 22px; align-items: start; }

    /* ---------- ID card ---------- */
    .pf-id { position: sticky; top: 100px; overflow: hidden; background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }

    .pf-id-top {
        display: flex; align-items: center; gap: 10px; padding: 18px 20px 72px; color: var(--on-secondary);
        background: repeating-linear-gradient(135deg, rgba(255, 255, 255, .07) 0 12px, transparent 12px 24px), var(--secondary-color);
        font-weight: 700; font-size: 14px;
    }
    .pf-id-top i { font-size: 20px; }
    .pf-id-top span { flex: 1; min-width: 0; line-height: 1.3; overflow-wrap: anywhere; }
    .pf-id-top em { font-style: normal; font-size: 10px; font-weight: 800; letter-spacing: .14em; text-transform: uppercase; opacity: .75; }

    .pf-id-body { padding: 0 24px 24px; text-align: center; }

    .pf-photo-wrap { position: relative; width: 128px; margin: -64px auto 14px; }
    .pf-photo {
        display: grid; place-items: center; width: 128px; height: 128px; overflow: hidden; border-radius: 50%;
        border: 5px solid var(--surface-color); box-shadow: 0 0 0 3px var(--primary-color);
        background: var(--primary-soft); color: var(--secondary-color); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 40px; font-weight: 800;
    }
    .pf-photo img { width: 100%; height: 100%; object-fit: cover; }

    .pf-camera {
        position: absolute; right: 2px; bottom: 4px; width: 38px; height: 38px; display: grid; place-items: center; margin: 0; cursor: pointer;
        border: 3px solid var(--surface-color); border-radius: 50%; background: var(--primary-color); color: var(--on-primary); font-size: 15px;
        transition: transform .2s ease;
    }
    .pf-camera:hover { transform: scale(1.1); }

    .pf-id h2 { margin: 0 0 10px; font-size: 22px; font-weight: 800; overflow-wrap: anywhere; }

    .pf-chips { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-bottom: 20px; }
    .pf-chip { display: inline-flex; align-items: center; gap: 6px; padding: 5px 12px; border-radius: 999px; background: var(--primary-soft); color: var(--secondary-color); font-size: 12px; font-weight: 700; }

    .pf-details { margin: 0; text-align: left; }
    .pf-details > div { display: flex; justify-content: space-between; align-items: baseline; gap: 14px; padding: 11px 0; border-top: 1px solid var(--border-color); }
    .pf-details dt { flex: 0 0 auto; color: var(--muted-color); font-size: 12px; font-weight: 700; }
    .pf-details dd { margin: 0; font-size: 13px; font-weight: 600; text-align: right; overflow-wrap: anywhere; }

    .pf-locked { margin: 14px 0 0; color: var(--muted-color); font-size: 12px; }

    /* ---------- Snapshot ---------- */
    .pf-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; margin-bottom: 18px; }
    .pf-stat { display: flex; align-items: center; gap: 14px; padding: 18px; background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }
    .pf-stat-icon { flex: 0 0 auto; width: 46px; height: 46px; display: grid; place-items: center; border-radius: 14px; background: var(--primary-soft); color: var(--secondary-color); font-size: 21px; }
    .pf-stat b { display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 26px; font-weight: 800; line-height: 1.1; letter-spacing: -.03em; }
    .pf-stat small { color: var(--muted-color); font-size: 12px; font-weight: 600; }

    /* ---------- Settings card + tabs ---------- */
    .pf-card { padding: 8px 28px 28px; background: var(--surface-color); border: 1px solid var(--border-color); border-radius: var(--radius-lg); box-shadow: var(--shadow-soft); }

    .pf-tabs { display: flex; gap: 28px; margin: 0 0 8px; border-bottom: 1px solid var(--border-color); }
    .pf-tabs button {
        margin-bottom: -1px; padding: 18px 2px 14px; border: 0; border-bottom: 3px solid transparent; background: transparent;
        color: var(--muted-color); font: inherit; font-size: 15px; font-weight: 800; transition: color .2s ease, border-color .2s ease;
    }
    .pf-tabs button:hover { color: var(--text-color); }
    .pf-tabs button.active { color: var(--text-color); border-bottom-color: var(--primary-color); }
    .pf-tabs button:focus-visible { outline: 3px solid color-mix(in srgb, var(--primary-color) 45%, transparent); outline-offset: 2px; border-radius: 6px; }

    .pf-sub { margin: 16px 0 0; color: var(--muted-color); font-size: 13px; line-height: 1.6; }

    /* ---------- Forms ---------- */
    .pf-label { display: block; margin: 20px 0 7px; font-size: 13px; font-weight: 700; }
    .pf-input {
        width: 100%; height: 48px; padding: 0 14px; border: 1px solid var(--border-color); border-radius: 12px; outline: none;
        background: var(--surface-color); color: var(--text-color); font: inherit; font-size: 14px;
    }
    .pf-input:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary-color) 20%, transparent); }
    .pf-input.invalid { border-color: #e5484d; }

    .pf-pass { position: relative; }
    .pf-pass .pf-input { padding-right: 48px; }
    .pf-eye { position: absolute; right: 6px; top: 50%; transform: translateY(-50%); width: 36px; height: 36px; border: 0; border-radius: 10px; background: transparent; color: var(--muted-color); }
    .pf-eye:hover { background: var(--primary-soft); }

    .pf-help { margin-top: 8px; color: var(--muted-color); font-size: 12px; }
    .pf-note { margin-top: 10px; padding: 9px 12px; border-radius: 10px; background: var(--primary-soft); color: var(--secondary-color); font-size: 13px; font-weight: 600; }
    .pf-error { margin-top: 6px; color: #d92d20; font-size: 12px; font-weight: 600; }
    .pf-error:empty { display: none; }

    .pf-photo-actions { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
    .pf-actions { display: flex; align-items: center; flex-wrap: wrap; gap: 10px; margin-top: 26px; }

    .pf-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 8px; min-height: 44px; padding: 0 20px; margin: 0;
        border: 1px solid transparent; border-radius: 12px; font: inherit; font-size: 14px; font-weight: 800; cursor: pointer;
        transition: transform .2s ease, background .2s ease, opacity .2s ease;
    }
    .pf-btn.solid { background: var(--primary-color); color: var(--on-primary); }
    .pf-btn.solid:hover:not(:disabled) { background: var(--secondary-color); color: var(--on-secondary); transform: translateY(-1px); }
    .pf-btn.solid:disabled { opacity: .45; cursor: not-allowed; }
    .pf-btn.ghost { background: var(--surface-color); border-color: var(--border-color); color: var(--text-color); }
    .pf-btn.ghost:hover { background: var(--primary-soft); }
    .pf-btn.link { min-height: 38px; padding: 0 8px; background: transparent; color: var(--muted-color); }
    .pf-btn.link:hover { color: var(--text-color); }
    .pf-btn.link.danger { color: #d92d20; }
    .pf-btn:focus-visible, .pf-eye:focus-visible { outline: 3px solid color-mix(in srgb, var(--primary-color) 45%, transparent); outline-offset: 2px; }
    #pfPhoto:focus-visible ~ .pf-photo-actions .ghost { outline: 3px solid color-mix(in srgb, var(--primary-color) 45%, transparent); }

    .pf-meter { height: 6px; margin-top: 10px; border-radius: 99px; background: var(--border-color); overflow: hidden; }
    .pf-meter > div { height: 100%; width: 0; border-radius: 99px; background: #e5484d; transition: width .3s ease, background .3s ease; }

    /* ---------- Toast ---------- */
    .pf-toast { position: fixed; left: 50%; bottom: 26px; z-index: 2100; max-width: calc(100% - 32px); padding: 13px 20px; border-radius: 14px; color: #fff; background: #1f2937; font-size: 14px; font-weight: 600; transform: translateX(-50%); box-shadow: 0 14px 34px rgba(15, 23, 42, .3); }
    .pf-toast.ok { background: #15803d; }
    .pf-toast.bad { background: #b42318; }

    @media (max-width: 991px) {
        .pf-layout { grid-template-columns: 1fr; }
        .pf-id { position: static; max-width: 460px; width: 100%; margin: 0 auto; }
    }
    @media (max-width: 640px) {
        .pf-stats { grid-template-columns: 1fr; }
        .pf-card { padding: 4px 20px 22px; }
    }
    @media (prefers-reduced-motion: reduce) { .pf-camera, .pf-btn, .pf-meter > div, .pf-tabs button { transition: none; } }
</style>
@endpush


@push('scripts')
<script>
(function () {
    const token = localStorage.getItem('api_token');
    const authHeaders = { Accept: 'application/json', Authorization: 'Bearer ' + token };

    const $ = (id) => document.getElementById(id);

    let profile = null;        // what is saved on the server
    let newFile = null;        // a picture chosen but not saved yet
    let removePhoto = false;   // the student pressed "Remove picture"
    let blobUrl = null;

    if (!token) { window.location.href = '/'; }


    /* ---------------------------------------------------------------
       Helpers
    --------------------------------------------------------------- */

    function initialsOf(name) {
        const letters = String(name || '').trim().split(/\s+/).filter(Boolean).slice(0, 2).map(function (w) { return w.charAt(0).toUpperCase(); }).join('');
        return letters || 'ST';
    }

    function photoUrl(path) {
        if (!path) return '';
        return /^https?:\/\//i.test(path) || path.charAt(0) === '/' ? path : '/storage/' + path.replace(/^\/+/, '');
    }

    function safeText(text) {
        const div = document.createElement('div');
        div.textContent = text == null ? '' : text;
        return div.innerHTML;
    }

    function toast(type, text) {
        const box = $('pfToast');
        box.textContent = text;
        box.className = 'pf-toast ' + type;
        box.hidden = false;
        clearTimeout(toast.timer);
        toast.timer = setTimeout(function () { box.hidden = true; }, 4500);
    }

    async function request(method, url, body, isForm) {
        const response = await fetch(url, {
            method: method,
            headers: isForm ? authHeaders : Object.assign({ 'Content-Type': 'application/json' }, authHeaders),
            body: body ? (isForm ? body : JSON.stringify(body)) : undefined
        });

        const data = await response.json().catch(function () { return {}; });

        if (response.status === 413) {
            throw { status: 413, data: { message: 'That picture is too large for the server. Please choose a smaller one.' } };
        }

        if (!response.ok || data.success === false) {
            throw { status: response.status, data: data };
        }

        return data;
    }

    function clearErrors(form) {
        form.querySelectorAll('.pf-error').forEach(function (el) { el.textContent = ''; });
        form.querySelectorAll('.pf-input').forEach(function (el) { el.classList.remove('invalid'); });
    }

    // Puts each server message under its own field. Returns true if any field matched.
    function showErrors(form, errors) {
        let shown = false;

        Object.keys(errors || {}).forEach(function (field) {
            const box = form.querySelector('[data-error="' + field + '"]');
            if (!box) return;

            box.textContent = errors[field][0];
            shown = true;

            const previous = box.previousElementSibling;
            const input = previous && (previous.classList.contains('pf-input') ? previous : previous.querySelector && previous.querySelector('.pf-input'));
            if (input) input.classList.add('invalid');
        });

        return shown;
    }


    /* ---------------------------------------------------------------
       Tabs
    --------------------------------------------------------------- */

    function showTab(name) {
        ['Profile', 'Password'].forEach(function (tab) {
            const on = tab === name;
            const button = $('tab' + tab);

            button.classList.toggle('active', on);
            button.setAttribute('aria-selected', on ? 'true' : 'false');
            button.tabIndex = on ? 0 : -1;
            $('panel' + tab).hidden = !on;
        });
    }

    $('tabProfile').addEventListener('click', function () { showTab('Profile'); });
    $('tabPassword').addEventListener('click', function () { showTab('Password'); });

    document.querySelector('.pf-tabs').addEventListener('keydown', function (event) {
        if (event.key === 'ArrowRight' || event.key === 'ArrowLeft') {
            const next = document.activeElement === $('tabProfile') ? 'Password' : 'Profile';
            showTab(next);
            $('tab' + next).focus();
        }
    });


    /* ---------------------------------------------------------------
       Drawing the page
    --------------------------------------------------------------- */

    // The picture the student would see right now (saved, newly chosen, or removed)
    function currentPhoto() {
        if (blobUrl) return blobUrl;
        if (removePhoto) return '';
        return photoUrl(profile.profile_image);
    }

    function renderPhoto() {
        const url = currentPhoto();
        const img = $('pfAvatarImg');

        if (url) {
            img.src = url;
            img.hidden = false;
            $('pfAvatarText').hidden = true;
        } else {
            img.removeAttribute('src');
            img.hidden = true;
            $('pfAvatarText').hidden = false;
            $('pfAvatarText').textContent = initialsOf($('pfNameInput').value || profile.name);
        }

        $('pfPhotoRemove').hidden = !url;
        $('pfPhotoLabel').textContent = url ? 'Change picture' : 'Choose picture';

        const note = $('pfPhotoNote');

        if (newFile) { note.textContent = 'New picture selected. Press Save changes to use it.'; note.hidden = false; }
        else if (removePhoto) { note.textContent = 'Your picture will be removed when you save.'; note.hidden = false; }
        else { note.hidden = true; }
    }

    function renderProfile(p) {
        profile = p;

        $('pfName').textContent = p.name;
        $('pfNameInput').value = p.name;

        $('dtEmail').textContent = p.email || '-';
        $('dtRoll').textContent = p.student_roll_no || '-';
        $('dtClass').textContent = (p.classes || []).join(', ') || '-';
        $('dtSince').textContent = p.created_at
            ? new Date(p.created_at).toLocaleDateString(undefined, { month: 'long', year: 'numeric' })
            : '-';

        if (p.institute && p.institute.name) $('idInstitute').textContent = p.institute.name;

        let chips = '<span class="pf-chip"><i class="bi bi-mortarboard-fill"></i> Student</span>';
        (p.classes || []).forEach(function (name) {
            chips += '<span class="pf-chip"><i class="bi bi-people-fill"></i> ' + safeText(name) + '</span>';
        });
        $('pfChips').innerHTML = chips;

        const s = p.stats || {};
        $('stCompleted').textContent = s.completed || 0;
        $('stAverage').textContent = s.completed ? s.average + '%' : '-';
        $('stBest').textContent = s.completed ? s.best + '%' : '-';

        renderPhoto();
        refreshSaveState();
    }

    // The top-right name and picture on every student page
    function updateHeader(p) {
        $('studentDisplayName').textContent = p.name;
        $('studentAvatarInitials').textContent = initialsOf(p.name);

        const img = $('studentAvatarImage');
        const url = photoUrl(p.profile_image);

        if (url) {
            img.src = url + (url.indexOf('?') === -1 ? '?v=' : '&v=') + Date.now();
            img.classList.remove('d-none');
            $('studentAvatarInitials').classList.add('d-none');
        } else {
            img.classList.add('d-none');
            img.removeAttribute('src');
            $('studentAvatarInitials').classList.remove('d-none');
        }
    }

    // If the profile has no institute name, use the one the layout loads into the sidebar
    (function watchSidebarInstitute() {
        const source = $('studentInstituteName');
        if (!source) return;

        const copy = function () {
            const text = source.textContent.trim();
            if (text && text !== 'Your Institute' && !(profile && profile.institute && profile.institute.name)) {
                $('idInstitute').textContent = text;
            }
        };

        copy();
        new MutationObserver(copy).observe(source, { childList: true, characterData: true, subtree: true });
    })();


    /* ---------------------------------------------------------------
       Edit profile (name + picture)
    --------------------------------------------------------------- */

    function isDirty() {
        return $('pfNameInput').value.trim() !== profile.name || !!newFile || removePhoto;
    }

    function refreshSaveState() {
        if (!profile) return;

        const validName = $('pfNameInput').value.trim().length >= 2;
        const dirty = isDirty();

        $('pfSave').disabled = !(dirty && validName);
        $('pfReset').hidden = !dirty;
    }

    function dropBlob() {
        if (blobUrl) { URL.revokeObjectURL(blobUrl); blobUrl = null; }
    }

    $('pfPhoto').addEventListener('change', function () {
        const file = this.files[0];
        const errorBox = document.querySelector('#profileForm [data-error="profile_image"]');

        if (!file || !profile) return;

        if (['image/jpeg', 'image/png', 'image/webp'].indexOf(file.type) === -1) {
            errorBox.textContent = 'Please choose a JPG, PNG or WebP picture.';
            this.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            errorBox.textContent = 'That picture is too large. The limit is 2 MB.';
            this.value = '';
            return;
        }

        errorBox.textContent = '';
        dropBlob();
        newFile = file;
        removePhoto = false;
        blobUrl = URL.createObjectURL(file);

        showTab('Profile');
        renderPhoto();
        refreshSaveState();
    });

    $('pfPhotoRemove').addEventListener('click', function () {
        dropBlob();
        $('pfPhoto').value = '';
        newFile = null;
        removePhoto = true;

        renderPhoto();
        refreshSaveState();
    });

    $('pfNameInput').addEventListener('input', function () {
        if (!profile) return;
        if (!currentPhoto()) renderPhoto();   // keeps the initials in step with the name
        refreshSaveState();
    });

    $('pfReset').addEventListener('click', function () {
        dropBlob();
        $('pfPhoto').value = '';
        newFile = null;
        removePhoto = false;
        $('pfNameInput').value = profile.name;
        clearErrors($('profileForm'));

        renderPhoto();
        refreshSaveState();
    });

    $('profileForm').addEventListener('submit', async function (event) {
        event.preventDefault();

        const form = this;
        const button = $('pfSave');

        clearErrors(form);

        const body = new FormData();
        body.append('name', $('pfNameInput').value.trim());

        if (newFile) body.append('profile_image', newFile);
        else if (removePhoto) body.append('remove_image', '1');

        button.disabled = true;
        button.textContent = newFile ? 'Uploading...' : 'Saving...';

        try {
            const response = await request('POST', '/api/student/profile', body, true);

            dropBlob();
            $('pfPhoto').value = '';
            newFile = null;
            removePhoto = false;

            renderProfile(response.data);
            updateHeader(response.data);
            toast('ok', 'Your profile was updated.');
        } catch (error) {
            const data = error.data || {};

            if (!showErrors(form, data.errors)) {
                toast('bad', data.message || 'Something went wrong. Please try again.');
            }
        }

        button.textContent = 'Save changes';
        refreshSaveState();
    });


    /* ---------------------------------------------------------------
       Change password
    --------------------------------------------------------------- */

    document.querySelectorAll('.pf-eye').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = $(this.dataset.toggle);
            const show = input.type === 'password';

            input.type = show ? 'text' : 'password';
            this.setAttribute('aria-label', show ? 'Hide password' : 'Show password');
            this.querySelector('i').className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    });

    $('pwNew').addEventListener('input', function () {
        const value = this.value;
        let score = 0;

        if (value.length >= 8) score++;
        if (value.length >= 12) score++;
        if (/[a-z]/.test(value) && /[A-Z]/.test(value)) score++;
        if (/\d/.test(value) || /[^A-Za-z0-9]/.test(value)) score++;

        const labels = ['At least 8 characters.', 'Weak. Try a longer password.', 'Okay. Add capitals or numbers.', 'Good.', 'Strong.'];
        const colors = ['#e5484d', '#e5484d', '#d97706', '#65a30d', '#16a34a'];
        const level = value ? Math.max(score, 1) : 0;

        $('pwBar').style.width = (level * 25) + '%';
        $('pwBar').style.background = colors[level];
        $('pwHint').textContent = labels[level];
    });

    $('passwordForm').addEventListener('submit', async function (event) {
        event.preventDefault();

        const form = this;
        const button = $('pwSave');

        clearErrors(form);

        if ($('pwNew').value !== $('pwConfirm').value) {
            showErrors(form, { password_confirmation: ['The two new passwords do not match.'] });
            return;
        }

        button.disabled = true;
        button.textContent = 'Changing...';

        try {
            await request('PUT', '/api/student/profile/password', {
                current_password: $('pwCurrent').value,
                password: $('pwNew').value,
                password_confirmation: $('pwConfirm').value
            });

            form.reset();
            $('pwBar').style.width = '0';
            $('pwHint').textContent = 'At least 8 characters.';
            toast('ok', 'Password changed. Your other devices were signed out.');
        } catch (error) {
            const data = error.data || {};

            if (!showErrors(form, data.errors)) {
                toast('bad', data.message || 'Could not change the password. Please try again.');
            }
        }

        button.disabled = false;
        button.textContent = 'Change password';
    });


    /* ---------------------------------------------------------------
       Start
    --------------------------------------------------------------- */

    request('GET', '/api/student/profile')
        .then(function (response) {
            renderProfile(response.data);
            updateHeader(response.data);
        })
        .catch(function (error) {
            const data = error.data || {};
            $('pfName').textContent = 'Profile unavailable';
            toast('bad', data.message || (error.status === 401 ? 'You are not logged in. Please log in again.' : 'Could not load your profile.'));
        });
})();
</script>
@endpush