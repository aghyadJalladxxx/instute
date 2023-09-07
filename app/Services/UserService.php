<?php

namespace App\Services;

use App\Http\Constants\ERoleConstants;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use function auth;
use function request;

class UserService
{
    public function register(RegisterRequest $request)
    {
        $role=Role::query();
        if($request->has('role_id')){
            $role=$role->where('id',$request->input('role_id'));
        }
        else {
            $role=$role->where('role',ERoleConstants::ROLE_STUDENT);
        }
        $role=$role->firstOrFail();

        $user = User::create(array_merge(
            $request->validated(),
            [
                'password' => bcrypt($request->password),
                'role_id'=>$role->id
            ],
        ));
        $extra_claims=[
            'role_id'=>$role->id,
            'user_id'=>$user->id
        ];
        $token=auth()->claims($extra_claims)->login($user);
        return [
            'user'=>$user,
            'token'=>$token
        ];
    }

    public function logIn($request){
        $credentials = [
            'email'=>$request->input('email'),
            'password'=>$request->input('password')
        ];
        $user=User::with('role')->where('email',request('email'))->firstOrFail();
        $extra_claims= [
            'user_id'=>$user->id,
            'role'=>$user->role->role
        ];
        if (! $token = auth()->claims($extra_claims)->attempt($credentials)) {
            throw new NotFoundHttpException();
        }

        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

    public function refreshToken()
    {
        $user=auth()->user();
        $user->load('role');
        $extra_claims=[
            'user_id'=>$user->id,
            'role_id'=>$user->role->id
        ];
        $token=auth()->claims($extra_claims)->refresh();
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }

}
