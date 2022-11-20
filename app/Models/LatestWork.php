<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LatestWork extends Model
{
    use HasFactory;

    protected $table = 'experts';

    protected $fillable = [
        'expert_id',
        'image',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class);
    }
}
