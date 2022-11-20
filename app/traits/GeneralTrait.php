<?php

namespace App\Traits;

use Illuminate\Support\Carbon;

trait GeneralTrait
{
    // to return login / register status message
    public function returnStatus($status,$msg)
    {
        return response()->json([
            'status' => $status,
            'msg' => $msg,
        ]);
    }

    // to return error message
    public function returnError($msg)
    {
        return response()->json([
            'status' => false,
            'data' => NULL,
            'msg' => $msg,
        ]);
    }

    // to return error message
    public function returnNotFounded($id , $class)
    {
        return response()->json([
            'status' => false,
            'data' => NULL,
            'msg' => 'No '.$class.' Founded With #ID '.$id,
        ]);
    }

    public function returnNotAvailable($id , $class)
    {
        return response()->json([
            'status' => false,
            'data' => NULL,
            'msg' => $class.' With #ID '.$id.' is not available',
        ]);
    }

    // to return Success message
    public function returnSuccessMessage($msg = "")
    {
        return response()->json([
            'status' => true,
            'msg' => $msg
        ]);
    }

    // to return data
    public function returnData($key, $value, $msg = "")
    {
        return response()->json([
            'status' => true,
            'msg' => $msg,
            $key => $value
        ]);
    }

    // to return error of the validation
    public function returnValidationError( $validator)
    {
        return $this->returnError($validator->errors()->first());
    }

}
