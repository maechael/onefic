<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fic}}`.
 */
class m211122_060011_create_fic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fic}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(150)->notNull()->unique(),
            'region_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('idx-fic-region_id', '{{%fic}}', 'region_id');
        $this->addForeignKey('fk-fic-region_id', '{{%fic}}', 'region_id', '{{%region}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-fic-region_id', '{{%fic}}');
        $this->dropIndex('idx-fic-region_id', '{{%fic}}');
        $this->dropTable('{{%fic}}');
    }
}
