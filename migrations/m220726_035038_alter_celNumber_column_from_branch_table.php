<?php

use yii\db\Migration;

/**
 * Class m220726_035038_alter_celNumber_column_from_branch_table
 */
class m220726_035038_alter_celNumber_column_from_branch_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%branch}}', 'celNumber', 'cellNumber');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%branch}}', 'cellNumber', 'celNumber');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220726_035038_alter_celNumber_column_from_branch_table cannot be reverted.\n";

        return false;
    }
    */
}
