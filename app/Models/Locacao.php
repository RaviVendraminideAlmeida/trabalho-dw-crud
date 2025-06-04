<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{

    protected $table = 'carro_user';
    protected $fillable = [
        'taken',
        'returned',
        'user_id',
        'carro_id'
    ];

}
