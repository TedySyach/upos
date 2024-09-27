<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('id'); // Tambah kolom user_id di tabel categories
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key ke tabel users
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after('category_id'); // Tambah kolom user_id di tabel products
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key ke tabel users
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
