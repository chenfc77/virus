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
 * Class TagValidator
 *
 * @since 2.0
 *
 * @Validator(name="TagValidator")
 */
class TagValidator
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
     * @IsInt(name="type",message="类型必须是数组")
     * @Enum(name="type",values={1,2},message="类型枚举错误")
     * @Required()
     *
     * @var int
     */
    protected $type = 1;
}
