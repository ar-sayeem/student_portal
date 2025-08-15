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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'teacher', 'student'])->default('student');
            $table->string('student_id')->nullable();
            $table->string('department')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('session')->nullable();
            $table->integer('semester')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'student_id', 'department', 'phone', 'address', 'session', 'semester']);
        });
    }
};
