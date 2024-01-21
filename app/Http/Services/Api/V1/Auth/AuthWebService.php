<?php

namespace App\Http\Services\Api\V1\Auth;

class AuthWebService extends AuthService
{
    public function whatIsMyPlatform() : string // will be invoked if the request came from website endpoints
    {
        return 'platform: website!';
    }
}
