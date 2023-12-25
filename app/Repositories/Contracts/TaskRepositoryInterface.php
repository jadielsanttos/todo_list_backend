<?php

namespace App\Repositories\Contracts;

interface TaskRepositoryInterface
{
    public function __construct();
    public function store(array $data);
    public function getAll(int $userID, string $order);
    public function get(string $taskID, int $userID);
    public function findByTitle(string $taskTitle, int $userID);
    public function update(array $data, string $taskID, int $userID);
    public function destroy(string $taskID, int $userID);
}
