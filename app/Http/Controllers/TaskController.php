<?php

namespace App\Http\Controllers;

use App\Services\TaskService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {

        $loggedUser = Auth::user();

        $data = [
            'user_id'     => $loggedUser->id,
            'title'       => $request->title,
            'description' => $request->description,
            'author'      => $request->author
        ];

        return $this->service->store($data);
    }

    public function getAll()
    {
        $loggedUser = Auth::user();

        $order = 'id';

        return $this->service->getAll($loggedUser->id, $order);
    }

    public function get($taskID)
    {
        $loggedUser = Auth::user();

        return $this->service->get($taskID, $loggedUser->id);
    }

    public function update(Request $request, $taskID)
    {
        $loggedUser = Auth::user();

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'author'      => $request->author
        ];

        return $this->service->update($data, $taskID, $loggedUser->id);
    }

    public function destroy($taskID)
    {
        $loggedUser = Auth::user();

        return $this->service->destroy($taskID, $loggedUser->id);
    }
}
