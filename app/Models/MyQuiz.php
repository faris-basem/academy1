<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyQuiz extends Model
{
    use HasFactory;
    protected $table = 'my_quizzes';
    protected $guarded = [];
}
