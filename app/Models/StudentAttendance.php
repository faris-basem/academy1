<?php

namespace App\Models;

use App\Models\Lecture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentAttendance extends Model
{
    use HasFactory;
    protected $table = 'students_attendance';
    protected $guarded = [];


    public function lectures()
    {
        return $this->belongsTo(Lecture::class,'lecture_id');
    }
}
