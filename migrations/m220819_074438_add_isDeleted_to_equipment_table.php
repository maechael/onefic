<?php

use yii\db\Migration;

/**
 * Class m220819_074438_add_isDeleted_to_equipment_table
 */
class m220819_074438_add_isDeleted_to_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment}}', 'isDeleted', $this->boolean()->defaultValue(false)->after('image_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%equipment}}', 'isDeleted');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220819_074438_add_isDeleted_to_equipment_table cannot be reverted.\n";

        return false;
    }
    */
}
