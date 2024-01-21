<?php

namespace App\Http\Services\Api\V1\Auth;

class AuthMobileService extends AuthService
{

    public function whatIsMyPlatform() : string // will be invoked if the request came from mobile endpoints
    {
        return 'platform: mobile!';
    }

}
