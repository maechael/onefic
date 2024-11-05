<?php

use yii\db\Migration;

/**
 * Class m211201_015606_seed_equipment_type_table
 */
class m211201_015606_seed_equipment_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->upsert('{{%equipment_type}}', ['name' => 'Vacuum Fryer'], true);
        $this->upsert('{{%equipment_type}}', ['name' => 'Freeze Dryer'], true);
        $this->upsert('{{%equipment_type}}', ['name' => 'Water Retort Machine'], true);
        $this->upsert('{{%equipment_type}}', ['name' => 'Spray Dryer'], true);
        $this->upsert('{{%equipment_type}}', ['name' => 'Vacuum Packaging Machine'], true);
        $this->upsert('{{%equipment_type}}', ['name' => 'Cabinet Dryer'], true);
        $this->upsert('{{%equipment_type}}', ['name' => 'Band Sealer'], true);
        $this->upsert('{{%equipment_type}}', ['name' => 'Can Seamer'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment-equipment_type_id', '{{%equipment}}');
        $this->dropIndex('idx-equipment-equipment_type_id', '{{%equipment}}');

        $this->truncateTable('{{%equipment_type}}');

        $this->createIndex('idx-equipment-equipment_type_id', '{{%equipment}}', 'equipment_type_id');
        $this->addForeignKey('fk-equipment-equipment_type_id', '{{%equipment}}', 'equipment_type_id', '{{%equipment_type}}', 'id', 'CASCADE');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211201_015606_seed_equipment_type_table cannot be reverted.\n";

        return false;
    }
    */
}
