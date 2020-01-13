<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contato extends Model
{
    //
    use SoftDeletes;
    protected $table = 'contatos';

    protected $fillable = [
        'name', 'tel','email','created_at','updated_at'
    ];
}
