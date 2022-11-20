<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCodeRequest;
use App\Http\Resources\ProviderResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\VerificationCode;
use App\Traits\GeneralTrait;
use Auth;
use Carbon\Carbon;

class VerificationController extends Controller
{
    use GeneralTrait;

    public function verify(StoreCodeRequest $request)
    {

        $code = VerificationCode::where(['code' => $request->code])
                                   ->where('information', $request->phone)
                                   ->where('used', 0)
                                   ->where('expired_at', '>' ,Carbon::now())
                                    ->first();
        if (!is_null($code))
        {
                $user = User::where('phone',$request->phone)->with('address')->first();
                $user['token']= $user->createToken("API TOKEN")->plainTextToken;
                $code->update(['used' => 1]);

            if ($user->user_type == 'user') {
                return $this->returnData('Data', new UserResource($user) , 'Logged in Successfully');
            }
            if($user->user_type == 'provider') {
                return $this->returnData('Data', new ProviderResource($user) , 'Logged in Successfully');
            }


        }else{
            return $this->returnError('Not Valid');
        }

    }

}
