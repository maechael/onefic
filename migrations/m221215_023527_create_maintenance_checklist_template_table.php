<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%maintenance_checklist_template}}`.
 */
class m221215_023527_create_maintenance_checklist_template_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%maintenance_checklist_template}}', [
            'id' => $this->primaryKey(),
            'equipment_id' => $this->integer(),
            'accomplished_by' => $this->string()->notNull(),
            'designation' => $this->string(),
            'office' => $this->string(),
            'date' => $this->date(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-maintenance_checklist_template-equipment_id', '{{%maintenance_checklist_template}}', 'equipment_id');
        $this->addForeignKey('fk-maintenance_checklist_template-equipment_id', '{{%maintenance_checklist_template}}', 'equipment_id', '{{%equipment}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-maintenance_checklist_template-equipment_id', '{{%maintenance_checklist_template}}');
        $this->dropIndex('idx-maintenance_checklist_template-equipment_id', '{{%maintenance_checklist_template}}');

        $this->dropTable('{{%maintenance_checklist_template}}');
    }
}
