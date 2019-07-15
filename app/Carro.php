<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    protected $table = 'carros';
    protected $primaryKey = 'carro_id';
    protected $attributes = [
        'carro_data' => false,
    ];
}
