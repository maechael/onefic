<?php

use yii\db\Migration;

/**
 * Class m220506_020242_alter_name_column_from_metadata_table
 */
class m220506_020242_alter_name_column_from_metadata_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%metadata}}', 'name', 'basename');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%metadata}}', 'basename', 'name');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220506_020242_alter_name_column_from_metadata_table cannot be reverted.\n";

        return false;
    }
    */
}
