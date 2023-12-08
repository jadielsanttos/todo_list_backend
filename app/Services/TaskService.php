<?php

namespace App\Services;

use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

class TaskService
{
    private $repo;

    public function __construct(TaskRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store(array $data): JsonResponse
    {
        $createTask = $this->repo->store($data);

        $createdTask = $this->repo->get($createTask->id, $data['user_id']);

        return response()->json([
            'message' => 'Tarefa criada com sucesso!',
            'data'    => $createdTask
        ],
            Response::HTTP_CREATED
        );
    }

    public function getAll($userID): JsonResponse
    {
        $tasks = $this->repo->getAll($userID);

        return response()->json([
            'message' => '', 'data' => $tasks
        ],
            Response::HTTP_OK
        );
    }

    public function get($taskID, $userID): JsonResponse
    {
        $task = $this->repo->get($taskID, $userID);

        if(empty($task)) {
            return response()->json([
                'error' => 'Tarefa não encontrada!'
            ],
                Response::HTTP_NOT_FOUND
            );
        }

        return response()->json([
            'message' => '',
            'data'    => $task
        ],
            Response::HTTP_OK
        );
    }

    public function update(array $data, $taskID, $userID): JsonResponse
    {
        $findTask = $this->repo->get($taskID, $userID);

        if(!$findTask) {
            return response()->json([
                'error' => 'Tarefa não encontrada!'
            ],
                Response::HTTP_NOT_FOUND
            );
        }

        $taskUpdated = $this->repo->update($data, $taskID, $userID);

        return response()->json([
            'message' => 'Tarefa editada com sucesso!',
            'data'    => $taskUpdated
        ],
            Response::HTTP_OK
        );
    }

    public function destroy($taskID, $userID)
    {
        $findTask = $this->repo->get($taskID, $userID);

        if(!$findTask) {
            return response()->json([
                'error' => 'Tarefa não encontrada!'
            ],
                Response::HTTP_NOT_FOUND
            );
        }

        $taskDeleted = $this->repo->destroy($taskID, $userID);

        return response()->json([
            'message' => 'Tarefa editada com sucesso!',
            'data'    => $taskDeleted
        ],
            Response::HTTP_OK
        );
    }
}
