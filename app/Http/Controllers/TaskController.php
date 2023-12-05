<?php

namespace App\Http\Controllers;

use App\Services\TaskService;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $service;

    private $loggedUser;

    public function __construct(TaskService $service)
    {
        $this->service = $service;

        $this->loggedUser = Auth::user();
    }

    public function store(Request $request)
    {
        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'author'      => $request->author
        ];

        return $this->service->store($data);
    }

    public function getAll()
    {
        return $this->service->getAll();
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
