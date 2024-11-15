<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Movimentacao extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'movimentacoes';
}
