<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string("userName")->unique();
            $table->string("email")->unique();
            $table->string("phone")->unique();
            $table->text("description")->default("اطلاعی ندارم :/");
            $table->string("profile");
            $table->string("password");
            $table->boolean("verify_phone")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
