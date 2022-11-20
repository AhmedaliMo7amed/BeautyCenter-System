<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Stephenjude\Wallet\Interfaces\Wallet;
use Stephenjude\Wallet\Traits\HasWallet;

class User extends Authenticatable implements Wallet
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasWallet;


    protected $table = 'users';

    protected $fillable = [
        'name',
        'nationality',
        'nat_id',
        'phone',
        'email',
        'user_type',
        'latitude',
        'longitude',
        'birthdate',
        'image',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function verficationCode(){
        return $this->hasMany(verificationCode::class);
    }

    public function offer(){
        return $this->hasMany(Offer::class);
    }

    public function address(){
        return $this->hasOne(UserAddress::class);
    }

    public function latestWork(){
        return $this->hasMany(LatestWork::class);
    }

    public function providerDetails(){
        return $this->hasOne(ProviderDetails::class);
    }

    public function categories(){
        return $this->belongsToMany(Category::class,ProviderCategory::class);
    }

    public function services(){
        return $this->hasMany(ProviderService::class);
    }

    public function packages(){
        return $this->hasMany(Package::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }


    /*************** JWT *************************/
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
