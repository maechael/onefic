<?php

use yii\db\Migration;

/**
 * Class m220119_001444_add_processing_capability_id_to_equipment_table
 */
class m220119_001444_add_processing_capability_id_to_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment}}', 'processing_capability_id', $this->integer()->notNull()->after('equipment_category_id'));

        $this->createIndex('idx-equipment-processing_capability_id', '{{%equipment}}', 'processing_capability_id');
        $this->addForeignKey('fk-equipment-processing_capability_id', '{{%equipment}}', 'processing_capability_id', '{{%processing_capability}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment-processing_capability_id', '{{%equipment}}');
        $this->dropIndex('idx-equipment-processing_capability_id', '{{%equipment}}');

        $this->dropColumn('{{%equipment}}', 'processing_capability_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220119_001444_add_processing_capability_id_to_equipment_table cannot be reverted.\n";

        return false;
    }
    */
}
