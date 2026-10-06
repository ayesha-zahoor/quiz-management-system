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
        Schema::table('classes', function (Blueprint $table) {
            $table->unsignedTinyInteger('class_number')->after('institute_id');
            $table->dropColumn(['class_name', 'group']);
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classes', function (Blueprint $table) {
             $table->string('class_name')->after('institute_id');
            $table->enum('group', ['primary', 'upper'])->after('class_name');
            $table->dropColumn('class_number');
        });
    }
};
