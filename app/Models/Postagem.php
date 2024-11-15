<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Postagem extends Model
{
    protected $connection = 'mongodb';
    //protected $database = 'tutorial_miniblog';
    //protected $collection = 'blogs';
    protected $table = 'blogs';
}
