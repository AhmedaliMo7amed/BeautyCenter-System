<?php

namespace App\Traits;

use App\Models\Category;
use App\Models\Offer;
use App\Models\Service;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;

trait FindTrait
{
    use GeneralTrait;

    // find category

    public function categoryFinder($id)
    {
        $category = Category::find($id);
        if (is_null($category)) {
            return false;
        }
        return $category;

    }

    public function servicFinder($id)
    {
        $service = Service::find($id);
        if (is_null($service)) {
            return false;
        }
        return $service;
    }

    public function offerFinder($id)
    {
        $offer = Offer::find($id);
        if (is_null($offer)) {
            return false;
        }
        return $offer;
    }

    public function offerAvailability($id)
    {
        $offer = Offer::find($id);
        if ($offer->status == 'expired' || $offer->status == 'accepted') {
            return false;
        }
        return $offer;
    }

    public function providerFinder($id)
    {
        $provider = User::with('services.service')->find($id);
        if (is_null($provider)) {
            return false;
        }
        return $provider;

    }



}
