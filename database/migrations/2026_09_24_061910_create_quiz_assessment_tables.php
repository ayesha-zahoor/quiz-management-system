<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institute_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institute_id')->unique()->constrained('institutes')->cascadeOnDelete();
            $table->string('logo_url')->nullable();
            $table->string('favicon_url')->nullable();
            $table->string('primary_color', 7)->default('#1E3A8A');
            $table->string('secondary_color', 7)->default('#2563EB');
            $table->string('accent_color', 7)->default('#F59E0B');
            $table->string('background_color', 7)->default('#F8FAFC');
            $table->string('text_color', 7)->default('#1F2937');
            $table->timestamp('updated_at')->nullable();
        });

        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institute_id')->constrained('institutes')->cascadeOnDelete();
            $table->string('class_name');
            $table->enum('group', ['primary', 'upper']);
            $table->timestamps();
        });

        Schema::create('class_student', function (Blueprint $table) {
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->primary(['class_id', 'user_id']);
        });

        Schema::create('class_teacher', function (Blueprint $table) {
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('teacher_id')->constrained('users')->cascadeOnDelete();
            $table->string('subject_name', 100)->nullable();
            $table->primary(['class_id', 'teacher_id']);
        });

        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users');
            $table->string('title');
            $table->enum('group', ['primary', 'upper']);
            $table->unsignedInteger('time_limit_minutes')->nullable();
            $table->unsignedInteger('pass_marks');
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->text('question_text');
            $table->string('image_url')->nullable();
            $table->string('tts_audio_url')->nullable();
            $table->unsignedInteger('marks_per_question')->default(1);
            $table->timestamps();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->text('option_text');
            $table->string('image_url')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });

        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained('quizzes')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users');
            $table->unsignedInteger('score')->default(0);
            $table->enum('status', ['in_progress', 'completed', 'timed_out']);
            $table->timestamp('started_at');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        Schema::create('student_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attempt_id')->constrained('quiz_attempts')->cascadeOnDelete();
            $table->foreignId('question_id')->constrained('questions')->cascadeOnDelete();
            $table->foreignId('selected_option_id')->nullable()->constrained('options')->nullOnDelete();
            $table->unique(['attempt_id', 'question_id']);
            $table->timestamps();
        });

        Schema::create('system_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_type', 50);
            $table->text('message');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_logs');
        Schema::dropIfExists('student_answers');
        Schema::dropIfExists('quiz_attempts');
        Schema::dropIfExists('options');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
        Schema::dropIfExists('class_teacher');
        Schema::dropIfExists('class_student');
        Schema::dropIfExists('classes');
        Schema::dropIfExists('institute_configurations');
    }
};
