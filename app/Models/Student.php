<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    // เพิ่มฟิลด์ทั้งหมดที่มาจากฟอร์มลงในนี้ เพื่อให้ระบบอนุญาตให้บันทึก (Mass Assignment)
    protected $fillable = [
        'student_id',
        'name',
        'nickname',
        'email',
        'birth_date',
        'gender',
        'classroom',
        'blood_group',
        'congenital_disease',
        'allergy',
        'parent_name',
        'parent_phone',
        'address',
        'image'
    ];

    /**
     * สำหรับการคำนวณอายุอัตโนมัติจากวันเกิด
     */
    public function getAgeAttribute()
    {
        return \Carbon\Carbon::parse($this->birth_date)->age;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function teacher()
    {
        return $this->belongsToMany(Teacher::class, 'student_teacher');
    }
}
