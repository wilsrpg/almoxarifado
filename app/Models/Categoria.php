<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Categoria extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'categorias';
}
