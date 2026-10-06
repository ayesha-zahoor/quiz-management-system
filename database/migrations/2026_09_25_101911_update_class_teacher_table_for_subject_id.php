<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('class_teacher', function (Blueprint $table) {
             $table->foreignId('subject_id')
        ->after('teacher_id')
        ->constrained('subjects')
        ->cascadeOnDelete();

    $table->dropColumn('subject_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('class_teacher', function (Blueprint $table) {
            //
        });
    }
};
