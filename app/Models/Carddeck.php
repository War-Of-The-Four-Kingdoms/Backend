<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carddeck extends Model
{
    use HasFactory;

    protected $fillable = [
        'in_use',
        'game',
        'order',
        'card'
    ];

    public function game(){
        return $this->belongsTo(Game::class);
    }

    public function cards(){
        return $this->belongsTo(Card::class);
    }
}
