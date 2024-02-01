<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Arrange;

class Pokemon extends Model
{
    use HasFactory;

    protected $table = 'pokemons';
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = [
        'created_at',
        'updated_at',
    ];

    public function arranges()
    {
        return $this->hasMany(Arrange::class, 'poke_id');
    }
}
