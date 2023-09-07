<?php

namespace App\Hooks;
use Firebase\JWT\JWT;

abstract class BaseHook
{
    protected $jwt_key;

    public function __construct()
    {
        $this->jwt_key=env('JWT_SECRET','CcWoe0GZevtT5Hczsk958MEABW6o4aaz6svh1SNC42XajPMoQer4P8Tg7ApoMDJq');
    }

    public  function createMicroServiceToken($data) {
        $payload=array_merge($data,[
            'iss' => $_SERVER['HTTP_HOST'],
            'aud' => 'microservices',
            'iat' => now()->toString(),
            'exp' => now()->add('minutes',60)
        ]);
        $jwt = JWT::encode($payload, $this->jwt_key, 'HS256');
        return $jwt;
    }

    abstract function postUpdates($data);
}
