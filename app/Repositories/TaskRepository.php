<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\Contracts\TaskRepositoryInterface;

class TaskRepository implements TaskRepositoryInterface
{

    protected $model;

    public function __construct()
    {
        $this->model = app(Task::class);
    }

    public function store(array $data)
    {
        return $this->model->create($data);
    }

    public function getAll(int $userID, string $order)
    {
        return $this->model->where('user_id', $userID)
            ->orderby($order, 'DESC')
            ->get();
    }

    public function get(string $taskID, int $userID)
    {
        return $this->model->where('id', $taskID)
            ->where('user_id', $userID)
            ->first();
    }

    public function update(array $data, string $taskID, int $userID)
    {
        return $this->model->where('id', $taskID)
            ->where('user_id', $userID)
            ->first()->update($data);
    }

    public function destroy(string $taskID, int $userID)
    {
        return $this->model->where('id', $taskID)
            ->where('user_id', $userID)
            ->first()->delete();
    }
}
