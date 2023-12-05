<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserServices
{
    private $repo;

    public function __construct(UserRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store(array $data): JsonResponse
    {
        $user = $this->repo->findByEmail($data['id']);

        if($user > 0) {
            return response()->json(['error' => 'Já existe um usuário com este email!'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->repo->store($data);
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
