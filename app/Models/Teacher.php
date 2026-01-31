<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'name',
        'email',
        'position',
        'department',
        'subject',
        'education_level',
        'start_date',
        'phone',
        'address',
        'motto',
        'image', // เพิ่ม , ตรงนี้
    ];
    /**
     * Get the user that owns the teacher.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the students for this teacher.
     */
    public function students()
    {
        return $this->belongsToMany(Student::class, 'student_teacher');
    }
}
