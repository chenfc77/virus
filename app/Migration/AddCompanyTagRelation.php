<?php declare(strict_types=1);


namespace App\Migration;


use Swoft\Devtool\Annotation\Mapping\Migration;
use Swoft\Devtool\Migration\Migration as BaseMigration;

/**
 * Class AddCompanyTagRelation
 *
 * @since 2.0
 *
 * @Migration(time=20200326233544)
 */
class AddCompanyTagRelation extends BaseMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $sql = <<<sql
CREATE TABLE `company_tag_relation` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公司 ID',
  `tag_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '标签 ID',
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
drop table if exists `company_tag_relation`;
sql;
        $this->execute($dropSql);
    }
}
