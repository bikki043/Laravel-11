<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_id')->unique(); // รหัสประจำตัวครู
            $table->string('name');                 // ชื่อ-นามสกุล
            $table->string('position')->nullable();  // ตำแหน่ง
            $table->string('department')->nullable(); // กลุ่มสาระ/แผนก
            $table->string('subject')->nullable();    // วิชาที่สอน
            $table->string('education_level')->nullable(); // วุฒิการศึกษา
            $table->date('start_date')->nullable();   // วันเริ่มงาน
            $table->string('email')->unique();        // อีเมล
            $table->string('phone')->nullable();      // เบอร์โทรศัพท์
            $table->text('address')->nullable();      // ที่อยู่
            $table->string('motto')->nullable();      // คติประจำใจ
            $table->string('image')->nullable();      // ชื่อไฟล์รูปภาพ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
