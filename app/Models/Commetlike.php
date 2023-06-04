<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commetlike extends Model
{
    use HasFactory;
    protected $table = 'commets_likes';
    protected $guarded = [];
}
