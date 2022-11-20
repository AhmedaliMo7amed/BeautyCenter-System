<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'offer_price',
        'payment',
        'wallet_balance',
        'location',
        'latitude',
        'longitude',
        'used_coupon',
        'coupon_id',
        'before_discount',
        'total',
        'expired_at',
        'status',
    ];

    public function providerService()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function user(){
        return $this->providerService();
    }

    public function offerServices()
    {
        return $this->hasMany(OfferService::class);
    }


    public function order(){
        return $this->hasOne(Order::class);
    }

}
