<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%part}}`.
 */
class m220831_003445_add_columns_to_part_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%part}}', 'isDeleted', $this->boolean()->defaultValue(false)->after('name'));
        $this->addColumn('{{%part}}', 'version', $this->integer()->defaultValue(1)->after('isDeleted'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%part}}', 'isDeleted');
        $this->dropColumn('{{%part}}', 'version');
    }
}
