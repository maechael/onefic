<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%maintenance_checklist_item_template}}`.
 */
class m221215_030717_create_maintenance_checklist_item_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%maintenance_checklist_item_template}}', [
            'id' => $this->primaryKey(),
            // 'maintenance_checklist_template_id' => $this->integer(),
            'equipment_id' => $this->integer(),
            'equipment_component_id' => $this->integer(),
            'criteria' => $this->text(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        // $this->createIndex('idx-mc_item_template-mc_template_id', '{{%maintenance_checklist_item_template}}', 'maintenance_checklist_template_id');
        // $this->addForeignKey('fk-mc_item_template-mc_template_id', '{{%maintenance_checklist_item_template}}', 'maintenance_checklist_template_id', '{{%maintenance_checklist_template}}', 'id', 'CASCADE');

        $this->createIndex('idx-mc_item_template-equipment_id', '{{%maintenance_checklist_item_template}}', 'equipment_id');
        $this->addForeignKey('fk-mc_item_template-equipment_id', '{{%maintenance_checklist_item_template}}', 'equipment_id', '{{%equipment}}', 'id', 'CASCADE');

        $this->createIndex('idx-mc_item_template-equipment_component_id', '{{%maintenance_checklist_item_template}}', 'equipment_component_id');
        $this->addForeignKey('fk-mc_item_template-equipment_component_id', '{{%maintenance_checklist_item_template}}', 'equipment_component_id', 'equipment_component', 'id', 'SET NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // $this->dropForeignKey('fk-mc_item_template-mc_template_id', '{{%maintenance_checklist_item_template}}');
        // $this->dropIndex('idx-mc_item_template-mc_template_id', '{{%maintenance_checklist_item_template}}');

        $this->dropForeignKey('fk-mc_item_template-equipment_id', '{{%maintenance_checklist_item_template}}');
        $this->dropIndex('idx-mc_item_template-equipment_id', '{{%maintenance_checklist_item_template}}');

        $this->dropForeignKey('fk-mc_item_template-equipment_component_id', '{{%maintenance_checklist_item_template}}');
        $this->dropIndex('idx-mc_item_template-equipment_component_id', '{{%maintenance_checklist_item_template}}');

        $this->dropTable('{{%maintenance_checklist_item_template}}');
    }
}
