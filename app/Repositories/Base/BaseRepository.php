<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as Application;

abstract class BaseRepository
{

    protected $model;

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    abstract public function model();

    public function makeModel()
    {
        $model = $this->app->make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relation = [])
    {
        return $this->model->with($relation)->get($columns);
    }

    public function find(int $id, array $columns = ['*'], array $relation = [])
    {
        return $this->model->with($relation)->findOrFail($id, $columns);
    }

    public function search(string $key, string $column, array $relation = [])
    {
        return $this->model->with($relation)->where($column, $key)->firstOrFail();
    }

    public function create(array $input)
    {
        return $this->model->create($input);
    }

    public function insert(array $input)
    {
        return $this->model->insert($input);
    }

    public function update(Model $model, array $input)
    {
        return $model->update($input);
    }

    public function delete(Model $model)
    {
        return $model->delete();
    }

    public function paginate(int $page = 10, array $relation = [])
    {
        return $this->model->with($relation)->paginate($page);
    }
}
