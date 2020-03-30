<?php declare(strict_types=1);

namespace App\Validator;

use App\Annotation\Mapping\AlphaDash;
use Swoft\Validator\Annotation\Mapping\IsInt;
use Swoft\Validator\Annotation\Mapping\IsString;
use Swoft\Validator\Annotation\Mapping\NotEmpty;
use Swoft\Validator\Annotation\Mapping\Enum;
use Swoft\Validator\Annotation\Mapping\Length;
use Swoft\Validator\Annotation\Mapping\Validator;

/**
 * Class CompanyValidator
 * @package App\Validator
 * @author congge
 *
 * @Validator(name="CompanyValidator")
 */
class CompanyValidator
{
    /**
     * @NotEmpty(name="name_cn",message="中文名不能为空")
     * @IsString(name="name_cn", message="中文名必须是字符串")
     * @Length(name="name_cn",max=64,message="中文名最大长度 64 字符")
     * @Required()
     *
     * @var string
     */
    protected $nameCn;

    /**
     * @NotEmpty(name="name_cn",message="英文名不能为空")
     * @IsString(name="name_cn", message="英文名必须是字符串")
     * @Length(name="name_cn",max=64,message="英文名最大长度 64 字符")
     * @Required()
     *
     * @var string
     */
    protected $nameEn;

    /**
     * @NotEmpty(name="intro_cn",message="中文简介不能为空")
     * @IsString(name="intro_cn", message="中文简介必须是字符串")
     * @Required()
     *
     * @var string
     */
    protected $introCn;

    /**
     * @NotEmpty(name="name_cn",message="英文简介不能为空")
     * @IsString(name="name_cn", message="英文简介必须是字符串")
     * @Required()
     *
     * @var string
     */
    protected $introEn;

    /**
     * @NotEmpty(name="home_page",message="公司主页不能为空")
     * @IsString(name="home_page", message="公司主页必须是字符串")
     * @Required()
     *
     * @var string
     */
    protected $homePage;

}
