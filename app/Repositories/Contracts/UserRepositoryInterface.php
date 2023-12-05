<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function __construct();
    public function store(array $data);
    public function get(string $id);
    public function findByEmail(string $email);
}
