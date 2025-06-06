<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function users() : BelongsToMany
    {
        return 
            $this
                ->belongsToMany(User::class)
                ->withPivot(['taken', 'returned'])
                ->withTimestamps();
    }

}
