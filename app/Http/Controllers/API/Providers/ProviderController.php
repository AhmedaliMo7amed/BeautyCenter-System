<?php

namespace App\Http\Controllers\API\Providers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddServicesRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\StoreJoinCategoryRequest;
use App\Http\Resources\ProvWithoutTokenResource;
use App\Models\User;
use App\Traits\FindTrait;
use App\Traits\GeneralTrait;
use App\Traits\MediaTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class ProviderController extends Controller
{
    use GeneralTrait , FindTrait , MediaTrait;

    public function joinCategory(StoreJoinCategoryRequest $request){
        try {
            $data = $request->validated();
            $user = User::find(auth('sanctum')->user()->id);
            $user->categories()->syncWithoutDetaching($data['category_id']);

            return $this->returnSuccessMessage('Provider Joined Successfully');
        } catch(\Illuminate\Database\QueryException $ex){
            return $this->returnError('Category Not Valid');

        }

    }

    public function addService(StoreAddServicesRequest $request){
        $data = $request->all();
        $user = User::find(auth('sanctum')->user()->id);
        try {
            foreach ($data['service'] as $service) {
                if ( Arr::exists($service, 'course_certificate')) {
                    $service['course_certificate'] = $this->saveCertificate($service, 'certificates' ,'course_certificate');
                }
                if ( Arr::exists($service, 'experience_certificate')) {
                    $service['experience_certificate'] = $this->saveCertificate($service, 'certificates' ,'experience_certificate');
                }
                $user->services()->create($service);
            }
            return $this->returnSuccessMessage('Provider Services Added Successfully');
        } catch(\Illuminate\Database\QueryException $ex){
            return $this->returnError('Not Valid!');
        }
    }

    public function addPackage(StoreAddServicesRequest $request){
        $data = $request->all();
        $user = User::find(auth('sanctum')->user()->id);
        try {
            if (Arr::exists($data['package'], 'national_card')) {
                $data['package']['national_card'] = $this->saveNationalCard($data['package']['national_card'], 'cards');
            }
            $package = $user->packages()->create($data['package']);
            foreach ($data['package']['service_id'] as $id) {
                $package->services()->syncWithoutDetaching($id);
            }
            return $this->returnSuccessMessage('Provider Package Added Successfully');
        } catch(\Illuminate\Database\QueryException $ex){
            return $this->returnError('Not Valid!');
        }
    }


}
