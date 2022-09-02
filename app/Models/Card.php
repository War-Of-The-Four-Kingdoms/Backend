<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'symbol',
        'type',
        'decision',
        'distance',
        'affected_gender',
        'immediately',
        'equipment_type',
        'active_type'
    ];

    public function players(){
        return $this->belongsToMany(Player::class,'owned');
    }
}
