<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fic_sns}}`.
 */
class m221115_055917_create_fic_sns_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fic_sns}}', [
            'id' => $this->primaryKey(),
            'fic_id' => $this->integer()->notNull(),
            'url' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex(
            '{{%idx-fic_sns-fic_id}}',
            '{{%fic_sns}}',
            'fic_id'
        );

        $this->addForeignKey(
            '{{%fk-fic_sns-fic_id}}',
            '{{%fic_sns}}',
            'fic_id',
            '{{%fic}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-fic_sns-fic_id}}',
            '{{%fic_sns}}'
        );

        $this->dropIndex(
            '{{%idx-fic_sns-fic_id}}',
            '{{%fic_sns}}'
        );

        $this->dropTable('{{%fic_sns}}');
    }
}
