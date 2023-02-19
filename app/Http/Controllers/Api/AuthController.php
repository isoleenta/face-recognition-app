<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth as AuthRequests;
use App\Services;
use Illuminate\Http\Request;
use Response;

class AuthController extends Controller
{
    public function __construct(
        private Services\Auth\AuthService $auth_service
    ) {
        //
    }

    public function handleUserRegister(AuthRequests\RegisterRequest $request)
    {
        $data = Services\DTO\Auth\RegisterData::from($request->all());

        $access_token = $this->auth_service->registerUser($data);

        return Response::send([
            'access_token' => $access_token,
        ]);
    }

    public function handleUserLogin(AuthRequests\LoginRequest $request)
    {
        $access_token = $this->auth_service->loginUser($request->email, $request->password);

        return Response::send([
            'access_token' => $access_token,
        ]);
    }

    public function handleUserLogout(Request $request)
    {
        $user = $request->user();

        $result = $this->auth_service->logoutUser(
            $user
        );

        return Response::send($result);
    }
}
