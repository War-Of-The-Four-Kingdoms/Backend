<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gender',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function skintone(){
        return $this->belongsTo(Skintone::class);
    }
    public function hair(){
        return $this->belongsTo(Hair::class);
    }
    public function face(){
        return $this->belongsTo(Face::class);
    }
    public function accessory(){
        return $this->belongsTo(Accessory::class);
    }
    public function top(){
        return $this->belongsTo(Top::class);
    }

}
