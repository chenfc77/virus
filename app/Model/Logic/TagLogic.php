<?php declare(strict_types=1);


namespace App\Model\Logic;

use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Bean\Annotation\Mapping\Bean;
use App\Model\Dao\TagDao;

/**
 * Class TagLogic
 * @package App\Model\Logic
 * @author congge
 *
 * @Bean()
 */
class TagLogic
{
    /**
     * @Inject()
     *
     * @var TagDao
     */
    public $tagDao;


    public function items($params)
    {
        $result = initListResult($params);
        $where = [];

        if (isset($params['type']) && '' !== $params['type']) {
            $where['type'] = $params['type'];
        }

        if (isset($params['name']) && '' !== $params['name']) {
            $where[] = ['name_cn', 'like', '%' . $params['name_cn'] . '%'];
        }
        $queryParams = [
            'page_num' => $result['page_num'],
            'page_size' => $result['page_size'],
            'where' => $where,
            'order_by' => ['id' => 'desc'],
        ];
        $result['list'] = $this->tagDao->getList($queryParams);
        $result['total'] = $this->tagDao->total($queryParams);
        return $result;
    }

    public function store(array $params): array
    {
        $data = [
            'name_cn' => $params['name_cn'] ?? '',
            'name_en' => $params['name_en'] ?? '',
            'type' => $params['type'],
            'created_at' => time(),
        ];

        $data['id'] = $this->tagDao->store($data);

        return $this->format($data);
    }

    public function show($id)
    {
        $result = $this->tagDao->findOne(['id' => $id]);
        if (!$result) {
            throw new \Exception('tag_not_exist', 404);
        }

        return $this->format($result);
    }


    public function update(array $params, int $id): array
    {
        $result = $this->show($id);
        $data['id'] = $id;
        $data['updated_at'] = time();
        $data['name_cn'] = $params['name_cn'] ?? $result['name_cn'];
        $data['name_en'] = $params['name_en'] ?? $result['name_en'];

        $this->tagDao->update($data, ['id' => $id]);
        return $this->format($data);
    }

    public function delete($id)
    {
        $this->show($id);
        $this->tagDao->delete(['id' => $id]);
    }

    private function format($data)
    {
        $result = [
            'id' => (int)$data['id'],
            'name_cn' => $data['name_cn'],
            'name_en' => $data['name_en'],
            'created_at' => (int)($data['created_at'] ?? 0),
            'updated_at' => (int)($data['updated_at'] ?? 0),
        ];

        return $result;
    }
}