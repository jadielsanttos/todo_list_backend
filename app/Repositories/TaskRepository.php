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

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function getAll($userID)
    {
        return $this->model->where('user_id', $userID)->get();
    }

    public function get($taskId, $userID)
    {
        return $this->model->where('id', $taskId)
            ->where('user_id', $userID)
            ->first();
    }

    public function update(array $data, $taskID, $userID)
    {
        return $this->model->where('id', $taskID)
            ->where('user_id', $userID)
            ->first()->update($data);
    }

    public function destroy($taskID, $userID)
    {
        return $this->model->where('id', $taskID)
            ->where('user_id', $userID)
            ->first()->delete();
    }
}
