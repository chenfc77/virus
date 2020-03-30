<?php declare(strict_types=1);


namespace App\Model\Dao;

use Swoft\Db\DB;
use Swoft\Bean\Annotation\Mapping\Bean;

/**
 * Class TagDao
 * @package App\Model\Dao
 * @author congge
 *
 * @Bean()
 *
 */
class TagDao
{

    private function getBuilder()
    {
        return DB::table('tag');
    }

    /**
     * @param $params
     * @return array
     * @throws \Swoft\Db\Exception\DbException
     */
    public function getList($params): array
    {
        $builder = $this->getBuilder()->where($params['where']);

        if (isset($params['page_num']) && isset($params['page_size'])) {
            $builder->forPage($params['page_num'], $params['page_size']);
        }

        if (isset($params['order_by'])) {
            foreach ($params['order_by'] as $column => $direction) {
                $builder->orderBy($column, $direction);
            }
        }
        return $builder->get()->toArray();
    }

    public function total(array $params): int
    {
        return (int)$this->getBuilder()->where($params['where'])->count();
    }

    public function findOne(array $where)
    {
        return $this->getBuilder()->where($where)->first();
    }


    public function store($data): int
    {
        return (int)$this->getBuilder()->insertGetId($data);
    }

    public function update($params, $where): int
    {
        return $this->getBuilder()->where($where)->update($params);
    }

    public function delete($where): int
    {
        return $this->getBuilder()->where($where)->delete();
    }
}