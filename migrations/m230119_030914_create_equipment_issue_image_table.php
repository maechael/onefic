<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_issue_image}}`.
 */
class m230119_030914_create_equipment_issue_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();
        try {
            $tableSchema = $this->db->getTableSchema('{{%equipment_issue_image}}');
            if ($tableSchema) {
                $this->dropTable('{{%equipment_issue_image}}');
            }
            $this->createTable('{{%equipment_issue_image}}', [
                'id' => $this->primaryKey(),
                'equipment_issue_id' => $this->integer()->notNull(),
                'local_media_id' => $this->integer()->notNull(),
            ]);

            $this->createIndex('idx-equipment_issue_image-equipment_issue_id', '{{%equipment_issue_image}}', 'equipment_issue_id');
            $this->addForeignKey('fk-equipment_issue_image-equipment_issue_id', '{{%equipment_issue_image}}', 'equipment_issue_id', '{{%equipment_issue}}', 'id', 'CASCADE');

            $this->createIndex('idx-equipment_issue_image-local_media_id', '{{%equipment_issue_image}}', 'local_media_id');
            $this->addForeignKey('fk-equipment_issue_image-local_media_id', '{{%equipment_issue_image}}', 'local_media_id', '{{%local_media}}', 'id', 'CASCADE');

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
        
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $transaction = $this->db->beginTransaction();
        try {
            $tableSchema = $this->db->getTableSchema('{{%equipment_issue_image}}');
            if ($tableSchema) {
                $this->dropForeignKey('fk-equipment_issue_image-equipment_issue_id', '{{%equipment_issue_image}}');
                $this->dropIndex('idx-equipment_issue_image-equipment_issue_id', '{{%equipment_issue_image}}');

                $this->dropForeignKey('fk-equipment_issue_image-local_media_id', '{{%equipment_issue_image}}');
                $this->dropIndex('idx-equipment_issue_image-local_media_id', '{{%equipment_issue_image}}');

                $this->dropTable('{{%equipment_issue_image}}');
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
