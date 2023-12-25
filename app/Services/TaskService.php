<?php

namespace App\Services;

use App\Repositories\Contracts\TaskRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use DateTime;

class TaskService
{
    private $repo;

    public function __construct(TaskRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function store($data): JsonResponse
    {
        $findByTitle = $this->repo->findByTitle($data['title'], $data['user_id']);

        if($findByTitle) {
            return response()->json([
                'error' => 'Você já possui uma tarefa com esse título!'
            ],
                Response::HTTP_OK
            );
        }

        $createTask = $this->repo->store($data);

        $createdTask = $this->repo->get($createTask->id, $data['user_id']);

        return response()->json([
            'message' => 'Tarefa criada com sucesso!',
            'data'    => $createdTask
        ],
            Response::HTTP_CREATED
        );
    }

    public function getAll($userID, $order): JsonResponse
    {
        $queryParam = request('order');

        if($queryParam !== null && $queryParam === 'updated_at') {
            $order = $queryParam;
        }

        $tasks = $this->repo->getAll($userID, $order);

        $finalList = ['data' => []];

        foreach($tasks as $task) {
            $dataTarget = $task->updated_at;
            $dateCurrent = New DateTime('now');

            $msgUpdatedAt = $this->calculateDiffBetweenDates($dataTarget, $dateCurrent);

            $newList = [
                'id'             => $task->id,
                'user_id'        => $task->user_id,
                'title'          => $task->title,
                'description'    => $task->description,
                'msg_updated_at' => $msgUpdatedAt
            ];

            array_push($finalList['data'], $newList);
        }

        return response()->json([
            'message' => '', 'data' => $finalList['data']
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

    public function update($data, $taskID, $userID): JsonResponse
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
            'message' => 'Tarefa excluida com sucesso!',
            'data'    => $taskDeleted
        ],
            Response::HTTP_OK
        );
    }

    public static function calculateDiffBetweenDates($dateTarget, $dateCurrent): string
    {
        $interval = $dateTarget->diff($dateCurrent);

        $msgUpdatedAt = '';

        if($interval->format('%a') > '0') {
            $msgUpdatedAt = $interval->format('Editado há %a').'d atrás';
        }else if($interval->format('%h') > '0') {
            $msgUpdatedAt = $interval->format('Editado há %h').'h atrás';
        }else if($interval->format('%i') > '0') {
            $msgUpdatedAt = $interval->format('Editado há %i').'m atrás';
        }else {
            $msgUpdatedAt = 'Editado agora mesmo';
        }

        return $msgUpdatedAt;
    }
}
