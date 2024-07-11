<?php

namespace App\Http\Services\Website\SMS;

class SmsService
{

    private function initalize()
    {
        $basic = new \Vonage\Client\Credentials\Basic("9eec0c8f", "yP4gH1ochLG8B3Kg");
        return new \Vonage\Client($basic);
    }

    public function sendSms()
    {
        $client=$this->initalize();
        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS("201012409123", 'HEDA', 'A text message sent using the Nexmo SMS API',)
        );

        $message = $response->current();
        return $message->getStatus() ;

    }
}
