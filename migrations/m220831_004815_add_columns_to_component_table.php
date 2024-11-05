<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%component}}`.
 */
class m220831_004815_add_columns_to_component_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%component}}', 'isDeleted', $this->boolean()->defaultValue(false)->after('description'));
        $this->addColumn('{{%component}}', 'version', $this->integer()->defaultValue(1)->after('isDeleted'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%component}}', 'isDeleted');
        $this->dropColumn('{{%component}}', 'version');
    }
}
