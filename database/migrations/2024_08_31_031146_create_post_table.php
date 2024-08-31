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
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->text("description");
            $table->string("slug")->unique();
            $table->json("photos");
            $table->foreignId("categories_id")->constrained(table: 'category', indexName: 'id');
            $table->foreignId("admin_id")->constrained(table: "admin", indexName: "id")->cascadeOnDelete();
            $table->boolean("status")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
