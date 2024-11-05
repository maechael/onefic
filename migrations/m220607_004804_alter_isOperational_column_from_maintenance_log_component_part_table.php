<?php

use yii\db\Migration;

/**
 * Class m220607_004804_alter_isOperational_column_from_maintenance_log_component_part_table
 */
class m220607_004804_alter_isOperational_column_from_maintenance_log_component_part_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%maintenance_log_component_part}}', 'isOperational', $this->boolean()->defaultValue(true));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%maintenance_log_component_part}}', 'isOperational', $this->boolean());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220607_004804_alter_isOperational_column_from_maintenance_log_component_part_table cannot be reverted.\n";

        return false;
    }
    */
}
