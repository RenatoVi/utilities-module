<?php

namespace Modules\Utilities\Userful\Bases;

class BaseService
{
    protected $repository;

    public function find($value, $key = 'id')
    {
        return $this->repository->find($value, $key);
    }

    public function create($data)
    {
        try {
            return $this->repository->create($data);
        } catch (Exception $exception) {
            throw $exception;
        }
    }

    public function findBy(array $criteria, $param = null)
    {
        try {
            return $this->repository->findBy($criteria, $param);
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }
}
