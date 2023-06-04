<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReplieLike extends Model
{
    use HasFactory;
    protected $table = 'replies_likes';
    protected $guarded = [];
}
