<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    public $timestamps = false;


    protected $fillable = [
        'user_id',
        'objective',
        'code',
        'information_type',
        'information',
        'used',
        'expired_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setObjectiveAttribute($key)
    {
        $this->attributes['objective']='verify';
    }
}
