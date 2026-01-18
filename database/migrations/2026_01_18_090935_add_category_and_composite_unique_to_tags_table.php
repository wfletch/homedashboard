<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            // Add category column
            $table->string('category')->nullable()->after('name');

            // Drop old unique constraint on name
            $table->dropUnique(['name']);

            // Add composite unique constraint
            $table->unique(['name', 'category']);
        });
    }

    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            // Remove composite unique
            $table->dropUnique(['name', 'category']);

            // Restore unique on name
            $table->unique('name');

            // Drop category column
            $table->dropColumn('category');
        });
    }
};
