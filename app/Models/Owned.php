<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owned extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_equipped'
    ];

    public function players(){
        return $this->belongsTo(Player::class);
    }

    public function cards(){
        return $this->belongsTo(Card::class);
    }
}
