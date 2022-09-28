<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'game',
        'user',
        'character',
        'role',
        'remain_hp',
        'is_playing'
    ];

    public function cards(){
        return $this->belongsToMany(Card::class,'owned');
    }
}
