<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_issue_image}}`.
 */
class m221122_081058_create_equipment_issue_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_issue_image}}', [
            'id' => $this->primaryKey(),
            'equipment_issue_id' => $this->integer()->notNull(),
            'media_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-equipment_issue_image-equipment_issue_id', '{{%equipment_issue_image}}', 'equipment_issue_id');
        $this->addForeignKey('fk-equipment_issue_image-equipment_issue_id', '{{%equipment_issue_image}}', 'equipment_issue_id', '{{%equipment_issue}}', 'id', 'CASCADE');

        $this->createIndex('idx-equipment_issue_image-media_id', '{{%equipment_issue_image}}', 'media_id');
        $this->addForeignKey('fk-equipment_issue_image-media_id', '{{%equipment_issue_image}}', 'media_id', '{{%metadata}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-equipment_issue_image-equipment_issue_id', '{{%equipment_issue_image}}');
        $this->dropIndex('idx-equipment_issue_image-equipment_issue_id', '{{%equipment_issue_image}}');

        $this->dropForeignKey('fk-equipment_issue_image-media_id', '{{%equipment_issue_image}}');
        $this->dropIndex('idx-equipment_issue_image-media_id', '{{%equipment_issue_image}}');

        $this->dropTable('{{%equipment_issue_image}}');
    }
}