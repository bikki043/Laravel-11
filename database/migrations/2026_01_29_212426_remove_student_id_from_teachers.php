<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            // ลบคอลัมน์ที่เป็นปัญหาออก
            if (Schema::hasColumn('teachers', 'student_id')) {
                $table->dropColumn('student_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->string('student_id')->nullable();
        });
    }
}; // ปีกกาปิดตัวสุดท้ายต้องมีเซมิโคลอนต่อท้ายแบบนี้ครับ