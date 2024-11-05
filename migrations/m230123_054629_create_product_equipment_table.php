<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product_equipment}}`.
 */
class m230123_054629_create_product_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $transaction = $this->db->beginTransaction();
        try {
            if ($this->db->getTableSchema('{{%product_equipment}}')) {
                $this->dropTable('{{%product_equipment}}');
            }
            $this->createTable('{{%product_equipment}}', [
                'id' => $this->primaryKey(),
                'product_id' => $this->integer()->notNull(),
                'equipment_id' => $this->integer()->notNull()
            ]);
            $this->createIndex('idx-product_equipment-product_id', '{{%product_equipment}}', 'product_id');
            $this->addForeignKey('fk-product_equipment-product_id', '{{%product_equipment}}', 'product_id', '{{%product}}', 'id', 'CASCADE');

            $this->createIndex('idx-product_equipment-equipment_id', '{{%product_equipment}}', 'equipment_id');
            $this->addForeignKey('fk-product_equipment-equipment_id', '{{%product_equipment}}', 'equipment_id', '{{%equipment}}', 'id', 'CASCADE');

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
            if ($tableSchema = $this->db->getTableSchema('{{%product_equipment}}')) {
                $foreignKeys = $tableSchema->foreignKeys;
                $indexes = $this->db->createCommand("SHOW INDEXES FROM `product_equipment` WHERE `Key_name` IN('idx-product_equipment-product_id', 'idx-product_equipment-equipment_id')")->queryAll();

                if (isset($foreignKeys['fk-product_equipment-product_id'])) {
                    $this->dropForeignKey('fk-product_equipment-product_id', '{{%product_equipment}}');
                }
                if (isset($foreignKeys['fk-product_equipment-equipment_id'])) {
                    $this->dropForeignKey('fk-product_equipment-equipment_id', '{{%product_equipment}}');
                }

                if ($indexes) {
                    foreach ($indexes as $i => $index) {
                        $this->dropIndex($index['Key_name'], $index['Table']);
                    }
                }
                $this->dropTable('{{%product_equipment}}');
            }

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }
}
