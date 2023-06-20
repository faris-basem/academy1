<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Parent1 extends Authenticatable
{
    use HasFactory, HasApiTokens;
    protected $table = 'parents';
    protected $guarded = [];
}
