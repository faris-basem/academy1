<?php

namespace App\Models;

use App\Models\Quiz;
use App\Models\Comment;
use App\Models\LessonAttachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;
    protected $table = 'lessons';
    protected $guarded = [];

    public function attachment()
    {
        return $this->hasMany(LessonAttachment::class,'lesson_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class,'lesson_id');
    }
    public function quizzes()
    {
        return $this->hasMany(Quiz::class,'lesson_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

}
