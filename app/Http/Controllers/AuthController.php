<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogInRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;

class AuthController extends Controller
{
    protected $user_service;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(UserService $user_service)
    {
        $this->user_service=$user_service;
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LogInRequest $request)
    {
        $result=$this->user_service->logIn($request);
        return response()->json($result);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $res=$this->user_service->refreshToken();
        return response()->json($res);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request) {
        $results=$this->user_service->register($request);
        return response()->json($results);
    }


}
