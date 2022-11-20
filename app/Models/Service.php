<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;


    protected $table = 'services';

    protected $fillable = [
        'parent_id',
        'name',
        'image',
    ];

    public function subService()
    {
        return $this->hasMany(Service::class, 'parent_id');
    }

    public function providerService()
    {
        return $this->hasMany(ProviderService::class);
    }

    public function packages(){
        return $this->belongsToMany(Package::class,PackageService::class);
    }

    public function offerInfo()
    {
        return $this->hasMany(OfferService::class);
    }

}
