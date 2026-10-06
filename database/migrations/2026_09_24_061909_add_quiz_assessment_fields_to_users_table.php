<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('license_key', 100)->nullable()->unique();
            $table->timestamp('license_expires_at')->nullable();
            $table->enum('status', ['active', 'suspended', 'expired'])->default('active');
            $table->timestamps();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('institute_id')->nullable()->after('id')->constrained('institutes')->nullOnDelete();
            $table->foreignId('role_id')->after('institute_id')->constrained('roles');
            $table->string('student_roll_no', 100)->nullable()->unique()->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['institute_id']);
            $table->dropForeign(['role_id']);
            $table->dropUnique(['student_roll_no']);
            $table->dropColumn(['institute_id', 'role_id', 'student_roll_no']);
        });

        Schema::dropIfExists('institutes');
    }
};
