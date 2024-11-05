<?php

use yii\db\Migration;

/**
 * Class m220428_021654_add_image_to_equipment_table
 */
class m220428_021654_add_image_id_to_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment}}', 'image_id', $this->integer()->after('processing_capability_id'));

        $this->createIndex('idx-equipment-image_id', '{{%equipment}}', 'image_id');
        $this->addForeignKey('fk-equipment-image_id', '{{%equipment}}', 'image_id', '{{%metadata}}', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment-image_id', '{{%equipment}}');
        $this->dropIndex('idx-equipment-image_id', '{{%equipment}}');

        $this->dropColumn('{{%equipment}}', 'image_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220428_021654_add_image_to_equipment_table cannot be reverted.\n";

        return false;
    }
    */
}
