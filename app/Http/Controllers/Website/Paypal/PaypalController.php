<?php

namespace App\Http\Controllers\Website\Paypal;

use App\Http\Controllers\Controller;
use App\Http\Requests\Paypal\PaypalRequest;
use App\Http\Services\Website\Paypal\PaypalService;
use Illuminate\Http\Request;

class PaypalController extends Controller
{
    public function __construct(
        private readonly PaypalService $paypalService
    ){
    }
    public function handle(PaypalRequest $request){
        return $this->paypalService->handle($request);
    }
    public function success(Request $request){
        return $this->paypalService->success($request);
    }
    public function cancel(){
        return $this->paypalService->cancel();
    }
}
