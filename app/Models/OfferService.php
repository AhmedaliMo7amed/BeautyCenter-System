<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfferService extends Model
{
    use HasFactory;
    protected $table = 'offer_services';
    public $timestamps = false;
    protected $fillable = [
        'offer_id',
        'service_id',
        'amount',
        'price',
        'total',
    ];


    public function serviceInfo()
    {
        return $this->belongsTo(Service::class,'service_id');
    }



}
