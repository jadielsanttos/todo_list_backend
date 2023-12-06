<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function unauthorized(): JsonResponse
    {
        return response()->json(['error' => 'Não autorizado!'], Response::HTTP_UNAUTHORIZED);
    }

    public function login(Request $request)
    {
        $fields = $request->only(['email', 'password']);

        return $this->service->login($fields);
    }

    public function register(Request $request)
    {
        $fields = $request->only(['email', 'password']);

        return $this->service->store($fields);
    }

    public function logout(Request $request)
    {
        if(Auth::check()) {
            $request->user()->currentAccessToken()->delete();
        }
    }
}
