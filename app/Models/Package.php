<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = 'packages';


    protected $fillable = [
        'user_id',
        'name',
        'price',
        'time',
        'description',
        'national_card',
    ];

    public function services(){
        return $this->belongsToMany(Service::class,PackageService::class);
    }

    public function provider()
    {
        return $this->belongsTo(User::class);
    }
}
