<?php

namespace App\Http\Services\Website\Paypal;

use App\Http\Services\Website\SMS\SmsService;
use App\Models\User;
use App\Notifications\InvoicePaid;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalService
{
    public function __construct(
        private readonly SmsService $smsService
    )
    {
    }

    public function handle($request)
    {
        $provider = new PayPalClient;

        $provider->setApiCredentials(config('paypal'));

        $paypalToken = $provider->getAccessToken();


        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $request->price
                    ]
                ]
            ]
        ]);
//        dd($response);
        if (isset($response['id']) && $response['id'] !== null) {
            if (!empty($response['links'])) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] == 'approve')
                        return redirect($link['href']);
                }
            }
        } else {
            return redirect()->route('paypal.cancel');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;

        $provider->setApiCredentials(config('paypal'));

        $paypalToken = $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);

        $messageStatus = $this->smsService->sendSms();
        if ($messageStatus != 0)
            return "The message failed with status: " . $messageStatus;
        if (isset($response['status']) && $response['status'] == 'COMPLETED')
            return 'Paid Successfully!';

        return redirect()->route('paypal.cancel');
    }

    public function cancel()
    {
        return 'Paymnet faild';
    }
}
