<?php

namespace App\Traits;

use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;

trait ConfirmationTrait
{
    use GeneralTrait;

    // to send code
    public function sendCode($request)
    {

        $user = User::where('phone',$request->phone)->first();

        if (is_null($user)) {
            $user = new User();
            $user->phone = $request->phone;
            $user->save();
        }
        // create new code
        $newCode = substr(str_shuffle("0123456789"), 0, 4);
        $myCode = VerificationCode::where('information',$request->phone)->first();

        if (is_null($myCode)) {
            $input = ([
                'code' => $newCode,
                'information' => $request->phone,
                'expired_at' => Carbon::now()->addMinutes(2),
            ]);
            $user->verficationCode()->create($request->validated()+$input);
            return $this->returnStatus(true ,'Verfication Code Sended');
        }

        $myCode->code = $newCode;
        $myCode->used = 0 ;
        $myCode->expired_at = Carbon::now()->addMinutes(2);
        $myCode->update();
        return $this->returnStatus(true ,'Verfication Code Sended');

    }


}
