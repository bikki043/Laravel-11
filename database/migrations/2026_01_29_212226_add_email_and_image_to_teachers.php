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
        Schema::table('teachers', function (Blueprint $table) {
            // เพิ่มคอลัมน์ที่ยังขาดอยู่
            if (!Schema::hasColumn('teachers', 'email')) {
                $table->string('email')->unique()->after('name');
            }
            if (!Schema::hasColumn('teachers', 'image')) {
                $table->string('image')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            //
        });
    }
};
