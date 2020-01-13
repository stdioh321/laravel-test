<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class curso extends Model
{
    use SoftDeletes;
    protected $table = 'cursos';
    protected $fillable = [
        'titulo',
        'decricao',
        'valor',
        'publicado',
        'imagem'
    ];
        //
}
