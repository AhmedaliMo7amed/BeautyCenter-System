<?php

namespace App\Http\Controllers\API\Providers;

use App\Events\OfferSent;
use App\Events\OrderAccepted;
use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use App\Traits\FindTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class DealsController extends Controller
{

    use GeneralTrait , FindTrait;
    public function allOffers()
    {
        $offers = Offer::with('user','offerServices.serviceInfo')->get();
        return $this->returnData('Data',$offers,'All Offers Sent');
    }

    public function showOffer($id)
    {
        $offer = Offer::find($id)->with('user','offerServices.serviceInfo')->first();
        return $this->returnData('Data',$offer,'Offer Sent');
    }

    public function showOrder($id)
    {
//        $offer = Offer::find($id)->with('user','offerServices.serviceInfo')->first();
//        return $this->returnData('Data',$offer,'Offer Sent');
    }

    public function acceptOffer($id)
    {
        $getOffer = $this->offerFinder($id);
        if (!$this->offerFinder($id)) {
            return $this->returnNotFounded($id , 'Offer');
        }
        if (!$this->offerAvailability($id)){
            return $this->returnNotAvailable($id , 'Offer');
        }
        $offer = $getOffer->with('offerServices.serviceInfo')->first();
        $data = $offer->only([
            'user_id',
            'total'
        ]);
        $data['provider_id'] = auth('sanctum')->user()->id;
        $order = $offer->order()->create($data);
        $userFinder = User::find($data['user_id']);
        event(new OrderAccepted($userFinder, $order));
        Offer::find($id)->update([
            'status' => 'accepted',
        ]);
        return $this->returnSuccessMessage('Order Accepted');
    }

}
