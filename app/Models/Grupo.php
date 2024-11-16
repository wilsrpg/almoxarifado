<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Grupo extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'grupos';
}
