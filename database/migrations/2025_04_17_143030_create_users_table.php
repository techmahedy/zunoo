<?php

use Zuno\Support\Facades\Schema;
use Zuno\Database\Migration\Blueprint;
use Zuno\Database\Migration\Migration;

return new class extends Migration
{
    /**
     * Run the migrations
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password', 100);
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
