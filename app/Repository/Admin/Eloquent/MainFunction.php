<?php
declare(strict_types=1);
namespace App\Repository\Admin\Eloquent;

abstract class MainFunction
{
    protected $model;

    public function getAll(string|array $columns = ['*']) {
        return $this->model->get($columns);
    }

    public function find(int $id) {
        return $this->model->findOrFail($id);
    }
}
