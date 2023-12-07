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

        return $this->service->getAll($loggedUser->id);
    }

    public function get($id)
    {
        return $this->service->get($id);
    }

    public function update(Request $request, $id)
    {
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'author'      => $request->author
        ];

        return $this->service->update($data, $id);
    }

    public function destroy($id)
    {
        return $this->service->destroy($id);
    }
}
