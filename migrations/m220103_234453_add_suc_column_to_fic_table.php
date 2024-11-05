<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fic}}`.
 */
class m220103_234453_add_suc_column_to_fic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fic}}', 'suc', $this->string(255)->after('region_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fic}}', 'suc');
    }
}
