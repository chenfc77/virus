<?php declare(strict_types=1);


namespace App\Model\Logic;

use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Bean\Annotation\Mapping\Bean;
use Swoft\Db\DB;
use App\Model\Dao\CompanyDao;
use function foo\func;

/**
 * Class CompanyLogic
 * @package App\Model\Logic
 * @author congge
 *
 * @Bean()
 */
class CompanyLogic
{
    /**
     * @Inject()
     *
     * @var CompanyDao
     */
    public $companyDao;


    public function items($params)
    {
        $result = initListResult($params);
        $tagIdArr = [];
        $catIdArr = [];
        $where = [];
        $trids = $crids = false;
        if (isset($params['tag_ids']) && '' !== $params['tag_ids']) {
            $tagIdArr = array_filter(explode(',', $params['tag_ids']));
            $trids = DB::table('company_tag_relation')->where(['tag_id' => $tagIdArr])->pluck('company_id')->toArray();
        }
        if (isset($params['category_ids']) && '' !== $params['category_ids']) {
            $catIdArr = array_filter(explode(',', $params['category_ids']));
            $crids = DB::table('company_tag_relation')->where(['tag_id' => $catIdArr])->pluck('company_id')->toArray();
            vdump($crids);
        }
        if (is_array($trids) && is_array($crids)) {
            $unionIds = array_intersect($trids, $crids);
            if (!empty($unionIds)) {
                $where['id'] = $unionIds;
            } else {
                $where['id'] = -1;
            }
        } elseif (is_array($trids)) {
            $where['id'] = empty($trids) ? -1 : $trids;
        } elseif (is_array($crids)) {
            $where['id'] = empty($crids) ? -1 : $crids;
        }
        $whereRow = [];
        if (isset($params['keyword']) && '' !== $params['keyword']) {
            $sql = " name_cn like '%" . $params['keyword'] . "%' or name_en like '%" . $params['keyword'] . "%'  or intro_cn like '%" . $params['keyword'] . "%'  or intro_en like '%" . $params['keyword'] . "%'";
            $whereRow = [
                'sql' => $sql,
                'bindings' => [
                ]
            ];
        }

        if (isset($params['status']) && '' !== $params['status']) {
            $where['status'] = $params['status'];
        }
        vdump($where);
        $queryParams = [
            'page_num' => $result['page_num'],
            'page_size' => $result['page_size'],
            'where' => $where,
            'where_row' => $whereRow,
            'order_by' => ['id' => 'desc'],
        ];
        $rows = $this->companyDao->getList($queryParams);
        $result['total'] = $this->companyDao->total($queryParams);
        foreach ($rows as $row) {
            $result['list'][] = $this->format($row);
        }
        return $result;
    }

    public function store(array $params): array
    {
        $data = [
            'name_cn' => $params['name_cn'] ?? '',
            'name_en' => $params['name_en'] ?? '',
            'intro_cn' => $params['intro_cn'] ?? '',
            'intro_en' => $params['intro_en'] ?? '',
            'home_page' => $params['home_page'],
            'status' => $params['status'] ?? 0,
            'created_at' => time(),
        ];

        $data['id'] = $this->companyDao->store($data);
        $tagIds = [];
        if (isset($params['tag_ids']) && '' !== $params['tag_ids']) {
            $tagIds = array_filter(explode(',', $params['tag_ids']));
        }
        if (isset($params['category_ids']) && '' !== $params['category_ids']) {
            $tagIds = array_merge($tagIds, array_filter(explode(',', $params['category_ids'])));
        }

        if (!empty($tagIds)) {
            array_walk($tagIds, function (&$value) {
                $value = (int)$value;
            });
            $relData = [];
            foreach (array_unique($tagIds) as $tagId) {
                $relData[] = [
                    'company_id' => $data['id'],
                    'tag_id' => $tagId,
                ];
            }
            DB::table('company_tag_relation')->insert($relData);
        }
        $data['tag_ids'] = $tagIds;

        return $this->format($data);
    }

    public function show($id)
    {
        $result = $this->companyDao->findOne(['id' => $id]);
        if (!$result) {
            throw new \Exception('company_not_exist', 404);
        }

        if (empty($params['is_admin'])) {
            DB::table('view_log')->insert(['company_id' => $id, 'ip' => \App\Helper\HttpHelper::getRemoteAddr(), 'created_at' => time()]);
            DB::table('company')->where(['id' => $id])->increment('view_count');
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
        $data['intro_cn'] = $params['intro_cn'] ?? $result['intro_cn'];
        $data['intro_en'] = $params['intro_en'] ?? $result['intro_en'];
        $data['home_page'] = $params['home_page'] ?? $result['home_page'];
        $data['status'] = $params['status'] ?? $result['status'];

        $this->companyDao->update($data, ['id' => $id]);


        DB::table('company_tag_relation')->where(['company_id' => $result['id']])->delete();
        $tagIds = [];
        if (isset($params['tag_ids']) && '' !== $params['tag_ids']) {
            $tagIds = array_filter(explode(',', $params['tag_ids']));
        }
        if (isset($params['category_ids']) && '' !== $params['category_ids']) {
            $tagIds = array_merge($tagIds, array_filter(explode(',', $params['category_ids'])));
        }

        if (!empty($tagIds)) {
            array_walk($tagIds, function (&$value) {
                $value = (int)$value;
            });
            $relData = [];
            foreach (array_unique($tagIds) as $tagId) {
                $relData[] = [
                    'company_id' => $data['id'],
                    'tag_id' => $tagId,
                ];
            }
            DB::table('company_tag_relation')->insert($relData);
        }

        $data['tag_ids'] = $tagIds;
        return $this->format($data);
    }

    public function delete($id)
    {
        $this->show($id);
        $this->companyDao->delete(['id' => $id]);
    }


    private function format($data)
    {
        $tagIds = DB::table('company_tag_relation')->where(['company_id' => $data['id']])->pluck('tag_id')->toArray();
        $categoryRows = DB::table('tag')->where(['id' => $tagIds, 'type' => 1])->select('id', 'name_cn', 'name_en')->get()->toArray();
        $tagRows = DB::table('tag')->where(['id' => $tagIds, 'type' => 2])->select('id', 'name_cn', 'name_en')->get()->toArray();

        $result = [
            'id' => (int)$data['id'],
            'name_cn' => $data['name_cn'] ?? '',
            'name_en' => $data['name_en'] ?? '',
            'intro_cn' => $data['intro_cn'] ?? '',
            'intro_en' => $data['intro_en'] ?? '',
            'home_page' => $data['home_page'] ?? '',
            'view_count' => $data['view_count'] ?? 0,
            'status' => $data['status'] ?? 0,
            'created_at' => (int)($data['created_at'] ?? 0),
            'updated_at' => (int)($data['updated_at'] ?? 0),
            'categorys' => $categoryRows,
            'tags' => $tagRows,
        ];

        return $result;
    }
}