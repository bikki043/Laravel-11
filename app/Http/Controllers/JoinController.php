<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\DB;

class JoinController extends Controller
{
    ///Left Join
    public function leftJoin()
    {
        $result = DB::table('students')
            ->leftJoin('teachers', 'students.id', '=', 'teachers.student_id')
            ->select('students.name as Student_name', 'teachers.name as Teacher_name')
            ->get();
        return $result;
    }
    ///Right Join
    public function rightJoin()
    {
        $result = DB::table('students')
            ->rightJoin('teachers', 'students.id', '=', 'teachers.student_id')
            ->select('students.name as Student_name', 'teachers.name as Teacher_name')
            ->get();
        return $result;
    }
    ///inner Join
    public function innerJoin()
    {
        $result = DB::table('students')
            ->join('teachers', 'students.id', '=', 'teachers.student_id')
            ->select('students.name as Student_name', 'teachers.name as Teacher_name')
            ->get();
        return $result;
    }
    ///full Outer Join
    public function FullOuterJoin()
    {
        $re_leftjoin = DB::table('students')
            ->leftJoin('teachers', 'students.id', '=', 'teachers.student_id')
            ->select('students.name as Student_name', 'teachers.name as Teacher_name');

        $re_rightjoin = DB::table('students')
            ->rightJoin('teachers', 'students.id', '=', 'teachers.student_id')
            ->select('students.name as Student_name', 'teachers.name as Teacher_name');
        $result = $re_leftjoin->union($re_rightjoin)
            ->get();
        return $result;
    }
}