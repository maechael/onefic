<?php

use yii\db\Migration;

/**
 * Class m211201_015150_seed_equipment_category_table
 */
class m211201_015150_seed_equipment_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->upsert('{{%equipment_category}}', ['name' => 'High Impact Technology Solution (HITS equipment)'], true);
        $this->upsert('{{%equipment_category}}', ['name' => 'Auxilary Equipment'], true);
        $this->upsert('{{%equipment_category}}', ['name' => 'Packaging Equipment'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment-equipment_category_id', '{{%equipment}}');
        $this->dropIndex('idx-equipment-equipment_category_id', '{{%equipment}}');

        $this->truncateTable('{{%equipment_category}}');

        $this->createIndex('idx-equipment-equipment_category_id', '{{%equipment}}', 'equipment_category_id');
        $this->addForeignKey('fk-equipment-equipment_category_id', '{{%equipment}}', 'equipment_category_id', '{{%equipment_category}}', 'id', 'CASCADE');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211201_015150_seed_equipment_category_table cannot be reverted.\n";

        return false;
    }
    */
}
