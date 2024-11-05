<?php

use yii\db\Migration;

/**
 * Class m220107_023721_alter_name_and_description_column_from_region_table
 */
class m220107_023721_alter_name_and_description_column_from_region_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%region}}', 'name', 'code');
        $this->renameColumn('{{%region}}', 'description', 'name');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%region}}', 'name', 'description');
        $this->renameColumn('{{%region}}', 'code', 'name');    
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220107_023721_alter_name_and_description_column_from_region_table cannot be reverted.\n";

        return false;
    }
    */
}
