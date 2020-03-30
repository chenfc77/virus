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
use App\Model\Logic\CompanyLogic;

/**
 * Class TagController
 * @Controller(prefix="/api")
 */
class CompanyController
{
    /**
     * @Inject()
     *
     * @var CompanyLogic
     */
    private $companyLogic;

    /**
     *
     *
     * @RequestMapping("companies",method=RequestMethod::POST)
     * @Validate(validator="CompanyValidator",fields={"nameCn","nameEn","introCn","introEn","homePage"})
     *
     * @param Request $request
     * @return Response
     * @throws
     */
    public function store(Request $request): Response
    {
        $result = $this->companyLogic->store($request->getParsedBody());
        return responseData($result);
    }

    /**
     * @RequestMapping("companies/{id}",method=RequestMethod::GET)
     *
     * @param int $id
     * @return Response
     * @throws
     */
    public function show(int $id): Response
    {
        $result = $this->companyLogic->show($id);
        return responseData($result);
    }

    /**
     *
     * @RequestMapping("companies/{id}",method=RequestMethod::PUT)
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $result = $this->companyLogic->update($request->getParsedBody(), $id);
        return responseData($result);
    }

    /**
     * @RequestMapping("companies/{id}", method=RequestMethod::DELETE)
     *
     * @param int $id
     * @return Response
     */
    public function delete(int $id): Response
    {
        $this->companyLogic->delete($id);
        return responseSuccess();
    }

    /**
     *
     * @RequestMapping("companies", method=RequestMethod::GET)
     *
     * @param Request $request
     * @return Response
     * @throws
     */
    public function items(Request $request): Response
    {
        $result = $this->companyLogic->items($request->getQueryParams());
        return responseData($result);
    }
}
