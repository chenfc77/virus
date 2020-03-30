<?php declare(strict_types=1);

namespace App\Http\Controller\Api;

use Swoft\Http\Message\Request;
use Swoft\Http\Message\Response;
use Swoft\Bean\Annotation\Mapping\Inject;
use Swoft\Validator\Annotation\Mapping\Validate;
use Swoft\Http\Server\Annotation\Mapping\Controller;
use Swoft\Http\Server\Annotation\Mapping\RequestMethod;
use Swoft\Http\Server\Annotation\Mapping\RequestMapping;
use Throwable;
use App\Model\Logic\TagLogic;

/**
 * Class TagController
 * @Controller(prefix="/api")
 */
class TagController
{
    /**
     * @Inject()
     *
     * @var TagLogic
     */
    private $tagLogic;

    /**
     *
     *
     * @RequestMapping("tags",method=RequestMethod::POST)
     * @Validate(validator="TagValidator",fields={"nameCn","type","nameEn"})
     *
     * @param Request $request
     * @return Response
     * @throws
     */
    public function store(Request $request): Response
    {
        $result = $this->tagLogic->store($request->getParsedBody());
        return responseData($result);
    }

    /**
     * @RequestMapping("tags/{id}",method=RequestMethod::GET)
     *
     * @param int $id
     * @return Response
     * @throws
     */
    public function show(int $id): Response
    {
        $result = $this->tagLogic->show($id);
        return responseData($result);
    }

    /**
     * 更新素材分类
     *
     * @RequestMapping("tags/{id}",method=RequestMethod::PUT)
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $result = $this->tagLogic->update($request->getParsedBody(), $id);
        return responseData($result);
    }

    /**
     * @RequestMapping("tags/{id}", method=RequestMethod::DELETE)
     *
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        $this->tagLogic->delete($id);
        return responseSuccess();
    }

    /**
     * 获取素材分类列表
     *
     * @RequestMapping("tags", method=RequestMethod::GET)
     *
     * @param Request $request
     * @return Response
     * @throws
     */
    public function items(Request $request): Response
    {
        $result = $this->tagLogic->items($request->getQueryParams());
        return responseData($result);
    }
}
