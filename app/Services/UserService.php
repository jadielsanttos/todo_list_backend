<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserService
{
    private $repo;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store(array $fields): JsonResponse
    {
        // Verificar se os campos estão vazios
        if($fields["email"] && $fields["password"]) {
            $verifyEmailExists = $this->repo->findByEmail($fields['email']);

            // Verificar se o email já existe
            if(!empty($verifyEmailExists)) {
                return response()->json([
                    'error' => 'Já existe um usuário com este email!'
                ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            // Criptografar senha
            $password = password_hash($fields['password'], PASSWORD_DEFAULT);

            // Criar usuario
            $newFields = [
                'email'    => $fields['email'],
                'password' => $password
            ];

            $createUser = $this->repo->store($newFields);

            // Criar token
            $token = $createUser->createToken('register_token')->plainTextToken;

            return response()->json([
                'message' => 'Usuário criado com sucesso!',
                'token'   => $token
            ],
                Response::HTTP_OK
            );
        }

        return response()->json([
            'error' => 'Preencha todos os campos!'
        ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function login(array $fields): JsonResponse
    {
        if(Auth::attempt($fields)) {
            $user = Auth::user();

            $token = $user->createToken('login_token')->plainTextToken;

            return response()->json([
                'message' => 'Logado com sucesso!',
                'token'   => $token
            ],
                Response::HTTP_ACCEPTED
            );
        }

        return response()->json([
            'error' => 'Dados incorretos!'
        ],
            Response::HTTP_UNAUTHORIZED
        );
    }

    public function get(string $id): JsonResponse
    {
        $user = $this->repo->get($id);

        if(empty($user)) {
            return response()->json(['error' => 'Usuário não encontrado!', 'data' => $user], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['error' => '', 'data' => $user], Response::HTTP_OK);
    }
}
