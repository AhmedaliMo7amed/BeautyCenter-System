<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProviderRegisterRequest;
use App\Http\Requests\StoreUserRegisterRequest;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\GeneralTrait;
use App\Traits\MediaTrait;
use Illuminate\Support\Arr;


class RegistrationController extends Controller
{

    use GeneralTrait , MediaTrait;

    public function userRegister(StoreUserRegisterRequest $request){
        $RegData = $request->validated();
        if($request->hasFile('image')) {
            $RegData['image'] = $this->saveImg($request, 'users');
        }
        $user = User::find(auth('sanctum')->user()->id);
        $user->update($RegData);
        $user->address()->create($RegData);
        $user->token = $request->bearerToken();

        return $this->returnData('Data', new UserResource($user) , 'User Registered Successfully');
    }

    public function providerRegister(StoreProviderRegisterRequest $request)
    {
        $RegData = $request->validated();
        if($request->hasFile('image')) {
            $RegData['image'] = $this->saveImg($request, 'providers');
        }

        $user = User::find(auth('sanctum')->user()->id);
        $user->update($RegData);
        $user->providerDetails()->create($RegData);
        $user->token = $request->bearerToken();

        foreach ($RegData['category_id'] as $id) {
            $user->categories()->attach($id);
        }
        foreach ($RegData['service'] as $service) {
            if ( Arr::exists($service, 'course_certificate')) {
                $service['course_certificate'] = $this->saveCertificate($service, 'certificates' ,'course_certificate');
            }
            if ( Arr::exists($service, 'experience_certificate')) {
                $service['experience_certificate'] = $this->saveCertificate($service, 'certificates' ,'experience_certificate');
            }
            $user->services()->create($service);
        }

        if (Arr::exists($RegData['package'], 'national_card')) {
            $RegData['package']['national_card'] = $this->saveNationalCard($RegData['package']['national_card'], 'cards');
        }
        $package = $user->packages()->create($RegData['package']);
        foreach ($RegData['package']['service_id'] as $id) {
            $package->services()->attach($id);
        }
        return $this->returnData('Data', new ProviderResource($user) , 'Provider Registered Successfully');
    }



}
