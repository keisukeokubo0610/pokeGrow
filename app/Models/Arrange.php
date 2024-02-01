<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pokemon;

class Arrange extends Model
{
    use HasFactory;

    protected $table = 'arranges';
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function pokemons()
    {
        return $this->belongsTo(Pokemon::class, 'poke_id', 'id');
    }
}
