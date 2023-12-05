<?php

namespace App\Repositories\Contracts;

interface TaskRepositoryInterface
{
    public function __construct();
    public function store(array $data);
    public function getAll();
    public function get($id);
    public function update(array $data, $id);
    public function destroy($id);
}
