<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * dodajem kolonu last name zbog normalizacije authors tabele
     */
    public function up(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->string('last_name')->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('authors', function (Blueprint $table) {
            $table->dropColumn('last_name');
        });
    }
};
