<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait MediaTrait
{

    public function saveImg($request , $class){
        $now = Carbon::now();
        $destinationPath = public_path().'/images/'.$class.'/'.$now->year.'/'.$now->month.'/';
        $userPhoto = $request->file('image');
        $name = $userPhoto->getClientOriginalName();
        $userNewPhoto =Carbon::now()->format('His').$name;
        $userPhoto->move($destinationPath,$userNewPhoto);
        return '/images/'.$class.'/'.$now->year.'/'.$now->month.'/'.$userNewPhoto;
    }

    public function saveCertificate($service , $class , $certifiacte){
        $now = Carbon::now();
        $destinationPath = public_path().'/images/'.$class.'/'.$now->year.'/'.$now->month.'/';
        $serviceCertificate = $service[$certifiacte];
        $name = $serviceCertificate->getClientOriginalName();
        $serviceNewPhoto =Carbon::now()->format('His').$name;
        $serviceCertificate->move($destinationPath,$serviceNewPhoto);
        return '/images/'.$class.'/'.$now->year.'/'.$now->month.'/'.$serviceNewPhoto;
    }

    public function saveNationalCard($package , $class ){
        $now = Carbon::now();
        $destinationPath = public_path().'/images/'.$class.'/'.$now->year.'/'.$now->month.'/';
        $packageCard = $package;
        $name = $packageCard->getClientOriginalName();
        $packageNewCard =Carbon::now()->format('His').$name;
        $packageCard->move($destinationPath,$packageNewCard);
        return '/images/'.$class.'/'.$now->year.'/'.$now->month.'/'.$packageNewCard;
    }

}
