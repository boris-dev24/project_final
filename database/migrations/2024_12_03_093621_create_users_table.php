<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// NOUVELLE TABLE
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id'); // BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY
            $table->string('username', 255)->unique(); // VARCHAR(255) UNIQUE
            $table->string('first_name', 255); // VARCHAR(255)
            $table->string('last_name', 255); // VARCHAR(255)
            $table->string('email', 255)->unique(); // VARCHAR(255) UNIQUE
            $table->string('password', 255); // VARCHAR(255)
            $table->enum('role', ['admin', 'user'])->default('user'); // ENUM('admin', 'user') DEFAULT 'user'
            $table->timestamps(); // created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
