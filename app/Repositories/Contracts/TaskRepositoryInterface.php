<?php

namespace App\Repositories\Contracts;

interface TaskRepositoryInterface
{
    public function __construct();
    public function store(array $data);
    public function getAll($userID);
    public function get($taskID, $userID);
    public function update(array $data, $taskID, $userID);
    public function destroy($taskID, $userID);
}
