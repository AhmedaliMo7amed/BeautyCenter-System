<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderDetails extends Model
{
    use HasFactory;

    protected $table = 'providers_details';

    protected $fillable = [
        'user_id',
        'description',
        'min_cost',
        'delivery_cost',
        'booking_status',
        'direct_serv_status',
        'experience',
        'avg_rate',
        'address_info'
    ];

    public function provider()
    {
        return $this->belongsTo(User::class);
    }
}
