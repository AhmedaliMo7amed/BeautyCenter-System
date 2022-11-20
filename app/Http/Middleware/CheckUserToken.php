<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use JWTAuth;

class CheckUserToken
{
    use GeneralTrait;
    public function handle(Request $request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
            if (auth()->guard('user-api')->user() instanceof User){
                return $next($request);
            }
        }
        catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this -> returnError('INVALID _TOKEN');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this -> returnError('EXPIRED_TOKEN');
            } else{
                return $this -> returnError('TOKEN_NOTFOUND');
            }
        }catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                return $this -> returnError('INVALID _TOKEN');
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return $this -> returnError('EXPIRED_TOKEN');
            } else{
                return $this -> returnError('TOKEN_NOTFOUND');
            }
        }
        return $this -> returnError('Unauthnticated');
    }
}
