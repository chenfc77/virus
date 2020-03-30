<?php declare(strict_types=1);


namespace App\Migration;


use Swoft\Devtool\Annotation\Mapping\Migration;
use Swoft\Devtool\Migration\Migration as BaseMigration;

/**
 * Class AddCompany
 *
 * @since 2.0
 *
 * @Migration(time=20200326230959)
 */
class AddCompany extends BaseMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $sql = <<<sql
CREATE TABLE `company` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name_cn` varchar(255) NOT NULL COMMENT '中文公司名',
  `name_en` varchar(255) NOT NULL COMMENT '英文公司名',
  `intro_cn` text NOT NULL COMMENT '中文简介',
  `intro_en` text NOT NULL COMMENT '简介',
  `home_page` varchar(64) NOT NULL COMMENT '主页',
  `view_count` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '浏览次数',
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
drop table if exists `company`;
sql;
        $this->execute($dropSql);
    }
}
