<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_media}}`.
 */
class m230123_074114_create_product_media_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();
        try {
            if ($this->db->getTableSchema('{{{%product_media}}')) {
                $this->dropTable('{{{%product_media}}');
            }
            $this->createTable('{{%product_media}}', [
                'id' => $this->primaryKey(),
                'product_id' => $this->integer()->notNull(),
                'media_id' => $this->integer()->notNull()
            ]);

            $this->createIndex('idx-product_media-product_id', '{{%product_media}}', 'product_id');
            $this->addForeignKey('fk-product_media-product_id', '{{%product_media}}', 'product_id', '{{%product}}', 'id', 'CASCADE');

            $this->createIndex('idx-product_media-media_id', '{{%product_media}}', 'media_id');
            $this->addForeignKey('fk-product_media-media_id', '{{%product_media}}', 'media_id', '{{%metadata}}', 'id', 'CASCADE');

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
            if ($tableSchema = $this->db->getTableSchema('{{%product_media}}')) {
                $foreignKeys = $tableSchema->foreignKeys;
                $indexes = $this->db->createCommand("SHOW INDEXES FROM `product_media` WHERE `Key_name` IN('idx-product_media-product_id', 'idx-product_media-media_id')")->queryAll();


                if (isset($foreignKeys['fk-product_media-product_id'])) {
                    $this->dropForeignKey('fk-product_media-product_id', '{{%product_media}}');
                }
                if (isset($foreignKeys['fk-product_media-media_id'])) {
                    $this->dropForeignKey('fk-product_media-media_id', '{{%product_media}}');
                }
                if ($indexes) {
                    foreach ($indexes as $i => $index) {
                        $this->dropIndex($index['Key_name'], $index['Table']);
                    }
                }
            }

            $this->dropTable('{{%product_media}}');
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
