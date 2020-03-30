<?php declare(strict_types=1);


namespace App\Migration;


use Swoft\Devtool\Annotation\Mapping\Migration;
use Swoft\Devtool\Migration\Migration as BaseMigration;

/**
 * Class AddTag
 *
 * @since 2.0
 *
 * @Migration(time=20200326231602)
 */
class AddTag extends BaseMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $sql = <<<sql
CREATE TABLE `tag` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_cn` varchar(255) NOT NULL COMMENT '中文名',
  `name_en` varchar(255) NOT NULL COMMENT '英文名',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '1-分类、2-标签',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `updated_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
sql;
        $this->execute($sql);

    }

    /**
     * @return void
     */
    public function down(): void
    {
        $dropSql = <<<sql
drop table if exists `tag`;
sql;
        $this->execute($dropSql);
    }
}
