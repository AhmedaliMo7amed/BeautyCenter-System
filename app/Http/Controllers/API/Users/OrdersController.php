<?php

namespace App\Http\Controllers\API\Users;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Traits\FindTrait;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Stephenjude\Wallet\Exceptions\InvalidAmountException;
use Stripe;
use Stephenjude\Wallet\Exceptions\InsufficientFundException;


class OrdersController extends Controller
{
    use GeneralTrait , FindTrait;

    public function showOrder($id){
        try {
            $order = Order::find($id)->first();
            return $this->returnData('Data',$order,'Order Sent');
        }catch (\Throwable $e){
            return $this->returnError($e->getMessage());
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage());
        }
    }

    public function completeOrder(Request $request,$id){
        try {
            $order = Order::find($id)->first();
            if ($request->payment_method == 'visa') {
                $validator =Validator::make($request->all() ,[
                    // User Validation
                    'number' => 'required' ,
                    'exp_month' => 'required' ,
                    'exp_year' => 'required' ,
                    'cvc' => 'required',
                ]);
                if ($validator->fails()) {
                    return $this->returnValidationError($validator);
                }
                $stripe = new \Stripe\StripeClient(
                    env('STRIPE_SECRET')
                );
                $token = $stripe->tokens->create([
                    'card' => [
                        'number' => $request->number,
                        'exp_month' => $request->exp_month,
                        'exp_year' => $request->exp_year,
                        'cvc' => $request->cvc,
                    ],
                ]);

                Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

                $response = $stripe->charges->create([
                    'amount' => $order->total * 100,
                    'source' => $token->id,
                    'currency' => 'SAR',
                ]);
                if ($response->status == 'succeeded')
                $order->update([
                    'status' => 'processing',
                    'transaction_no' => $response->id
                ]);
                return $this->returnSuccessMessage('Order Done');
            }
            if ($request->payment_method == 'wallet') {
                $user = User::find(auth('sanctum')->user()->id);
                $provider = User::where('id',$order->provider_id)->first();
                try {
                    $order->update([
                        'status' => 'processing',
                    ]);
                    $user->withdraw($order->total);
                    $provider->deposit($order->total);
                    $order->update([
                        'status' => 'processing',
                    ]);
                    return $this->returnSuccessMessage('Order Done');
                } catch (InvalidAmountException|InsufficientFundException $e) {
                    return $this->returnError($e->getMessage());
                }

            }
        }catch (\Throwable $e){
            return $this->returnError($e->getMessage());
        }
        catch (\Exception $ex){
            return $this->returnError($ex->getMessage());
        }
    }
}
