<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Carro extends Model
{
    protected $fillable = [
        'modelo',
        'marca',
        'status',
        'ano',
        'imagem',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


}
