<?php declare(strict_types=1);


namespace App\Migration;


use Swoft\Devtool\Annotation\Mapping\Migration;
use Swoft\Devtool\Migration\Migration as BaseMigration;

/**
 * Class AddViewLog
 *
 * @since 2.0
 *
 * @Migration(time=20200329203052)
 */
class AddViewLog extends BaseMigration
{
    /**
     * @return void
     */
    public function up(): void
    {
        $sql = <<<sql
CREATE TABLE `view_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `company_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '公司 ID',
  `ip` varchar(255) NOT NULL COMMENT 'IP',
  `created_at` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
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
drop table if exists `view_log`;
sql;
        $this->execute($dropSql);
    }
}
