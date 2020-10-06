<?php

namespace App\Repositories;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->setModel();
    }

    abstract public function getModel();

    public function setModel()
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    public function index()
    {
        return $this->model->all();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function store($data)
    {
        return $this->model->store($data);
    }

    public function update($id, $data)
    {
        return $this->model->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->model->destroy($id);
    }
}
