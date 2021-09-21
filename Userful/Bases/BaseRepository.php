<?php

namespace Modules\Utilities\Userful\Bases;

use Illuminate\Support\Facades\DB;

class BaseRepository
{
    protected $model;

    public function find($value, $key)
    {
        return $this->model->find($value);
    }

    /**
     * @throws \Exception
     */
    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $this->model->fill($data);
            $this->model->save();
            DB::commit();
            return $this->model;
        } catch (\Exception $exception) {
            DB::rollback();
            throw $exception;
        }
    }

    public function findBy($criteria = null, $param = null)
    {
        $result = $this->model->newQuery();

        if ($criteria) {
            $result->where($criteria);
        }

        //Verificar Order By
        if (isset($param['orderBy'])) {
            $type = (isset($param['type'])) ? $param['type'] : 'ASC';
            $result->orderBy($param['orderBy'], $type);
        }
        //Verifica LIMIT
        if (isset($param['limit'])) {
            $result->limit($param['limit']);
        }

        //Verifica WhereIn
        if (isset($param['whereIn'])) {
            if (is_array($param['whereIn'][0])) {
                foreach ($param['whereIn'] as $whereIn) {
                    $result->WhereIn($whereIn[0], $whereIn[1]);
                }
            } else {
                $result->WhereIn($param['whereIn'][0], $param['whereIn'][1]);
            }
        }

        return $result->get();
    }
}
