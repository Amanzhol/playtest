<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* @mixin \Eloquent
*/
class Book extends Model
{
    use HasFactory;

    public $timestamps = false;
}
