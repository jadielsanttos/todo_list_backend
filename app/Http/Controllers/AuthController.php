<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{

    public function unauthorized(): JsonResponse
    {
        return response()->json(['error' => 'Não autorizado!'], Response::HTTP_UNAUTHORIZED);
    }

    public function login()
    {

    }

    public function register()
    {

    }

    public function logout()
    {

    }
}
