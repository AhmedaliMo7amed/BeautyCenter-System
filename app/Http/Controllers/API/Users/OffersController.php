<?php

namespace App\Http\Controllers\API\Users;

use App\Events\OfferSent;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\StoreUserRequest;
use App\Models\Offer;
use App\Models\ProviderService;
use App\Models\Service;
use App\Models\User;
use App\Traits\FindTrait;
use App\Traits\GeneralTrait;
use App\Traits\MediaTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OffersController extends Controller
{
    use GeneralTrait , FindTrait , MediaTrait;

    public function index()
    {

    }


    public function store(StoreOfferRequest $request)
    {
        $offerData = $request->validated();
        $ids =[];
        $serviceList = [];
        $totalPrice = 0;
        $final = [];

        foreach ($offerData['service'] as $service) {
            $ids[] = $service['id'];
        }

        $serviceHolder = ProviderService::with('service')->whereIn('id',$ids)->get();
        foreach ($offerData['service'] as $service => $value) {
            $serviceList[] = $value;
        }

        foreach ($serviceList as $element){

            $target = $serviceHolder->where('id',$element['id'])->first();
            $element['service_id'] = $target['service_id'];
            $element['price'] = $target['price'];
            $element['total'] = $target['price'] * $element['amount'];
            $totalPrice +=  $element['total'];
            array_push($final, $element);
        }

        if($offerData['used_coupon'] == 0) {
            $offerData['before_discount'] = $totalPrice;
            $offerData['total'] = $totalPrice;
        }
        $offerData['expired_at'] = Carbon::now()->addMinutes(30);
        $user = auth('sanctum')->user();
        $offer = $user->offer()->create($offerData);
        foreach ($final as $element) {
            $offer->offerServices()->create($element);
        }

        $userFinder = User::find(auth('sanctum')->user()->id);
        $offerFinder = Offer::with('offerServices.serviceInfo')->where('id',$offer->id)->first();
        event(new OfferSent($userFinder, $offerFinder));
        return $this->returnSuccessMessage('Offer sent to all providers');

    }


    public function showOffers()
    {
        $offers = Offer::with('user','offerServices.serviceInfo')->where('user_id',auth('sanctum')->user()->id)->get();
        return $this->returnData('Data',$offers,'All Offers Sent');
    }

    public function showOffer($id)
    {
        try {
            $offer = Offer::find($id)->with('user','offerServices.serviceInfo')->first();
            return $this->returnData('Data',$offer,'Offer Sent');
        }catch (\Throwable $e){
            return $this->returnError($e->getMessage());
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage());
        }

    }





}
