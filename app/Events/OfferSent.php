<?php

namespace App\Events;

use App\Models\Offer;
use App\Models\OfferService;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class OfferSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $offer;

    public function __construct(User $user, $offer)
    {
        $this->user = $user;
        $this->offer = $offer;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('CurrentOffers');
    }
}
