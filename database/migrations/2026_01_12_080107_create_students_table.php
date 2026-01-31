<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_students_table.php
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('student_id')->unique(); // รหัสนักเรียน STU001
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->date('birth_date');             // วันเกิด
            $table->enum('gender', ['male', 'female', 'other']); // เพศ
            $table->string('classroom');            // ชั้นเรียน ม.1/1
            $table->string('blood_group')->nullable();
            $table->text('congenital_disease')->nullable(); // โรคประจำตัว
            $table->text('allergy')->nullable();            // ประวัติการแพ้
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->text('address');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
