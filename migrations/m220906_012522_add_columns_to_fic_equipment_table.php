<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fic_equipment}}`.
 */
class m220906_012522_add_columns_to_fic_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fic_equipment}}', 'isDeleted', $this->boolean()->defaultValue(false)->after('status'));
        $this->addColumn('{{%fic_equipment}}', 'version', $this->integer()->defaultValue(1)->after('isDeleted'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fic_equipment}}', 'isDeleted');
        $this->dropColumn('{{%fic_equipment}}', 'version');
    }
}
