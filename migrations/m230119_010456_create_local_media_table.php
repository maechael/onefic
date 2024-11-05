<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%local_media}}`.
 */
class m230119_010456_create_local_media_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();
        try {
            $tableSchema = $this->db->getTableSchema('{{%local_media}}');
            if ($tableSchema)
                $this->dropTable('{{%local_media}}');

            $this->createTable('{{%local_media}}', [
                'id' => $this->primaryKey(),
                'basename' => $this->string(255)->notNull(),
                'filename' => $this->string()->notNull(),
                'filepath' => $this->string()->notNull(),
                'type' => $this->string(50)->notNull(),
                'size' => $this->integer()->notNull(),
                'extension' => $this->string(50)->notNull(),
                'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
            ]);

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
            $tableSchema = $this->db->getTableSchema('{{%local_media}}');
            if ($tableSchema)
                $this->dropTable('{{%local_media}}');
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
