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

    public function get($id)
    {
        return $this->model->find($id);
    }

    public function update(array $data, $id)
    {
        return $this->model->find($id)->update($data);
    }

    public function destroy($id)
    {
        return $this->model->find($id)->delete();
    }
}
