<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Messages extends Model
{
    //

    protected $table = 'messages';

    protected $fillable = [
        'id',
        'title',
        'content',
        'created_at',
        'updated_at'
    ];
}
