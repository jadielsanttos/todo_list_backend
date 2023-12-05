<?php

namespace App\Repositories;

use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct()
    {
        $this->model = app(User::class);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function get(string $id)
    {
        return $this->model->find($id);
    }

    public function findByEmail(string $email)
    {
        return $this->model->find($email)->count();
    }
}
