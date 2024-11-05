<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment}}`.
 */
class m211201_012304_create_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment}}', [
            'id' => $this->primaryKey(),
            'model' => $this->string(200)->notNull()->unique(),
            'equipment_type_id' => $this->integer(),
            'equipment_category_id' => $this->integer(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-equipment-equipment_type_id', '{{%equipment}}', 'equipment_type_id');
        $this->addForeignKey('fk-equipment-equipment_type_id', '{{%equipment}}', 'equipment_type_id', '{{%equipment_type}}', 'id', 'CASCADE');

        $this->createIndex('idx-equipment-equipment_category_id', '{{%equipment}}', 'equipment_category_id');
        $this->addForeignKey('fk-equipment-equipment_category_id', '{{%equipment}}', 'equipment_category_id', '{{%equipment_category}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment-equipment_type_id', '{{%equipment}}');
        $this->dropIndex('idx-equipment-equipment_type_id', '{{%equipment}}');

        $this->dropForeignKey('fk-equipment-equipment_category_id', '{{%equipment}}');
        $this->dropIndex('idx-equipment-equipment_category_id', '{{%equipment}}');

        $this->dropTable('{{%equipment}}');
    }
}
