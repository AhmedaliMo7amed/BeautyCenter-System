<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderService extends Model
{
    use HasFactory;

    protected $table = 'provider_services';


    protected $fillable = [
        'user_id',
        'service_id',
        'price',
        'time',
        'experience',
        'description',
        'course_certificate',
        'experience_certificate',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class ,'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class,'service_id');
    }

    public function serviceOffers()
    {
        return $this->belongsTo(OfferService::class);
    }


}
