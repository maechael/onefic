<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%social_networking_site}}`.
 */
class m221115_053343_create_social_networking_site_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%social_networking_site}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(),
            'type' => $this->integer()->defaultValue(0),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%social_networking_site}}');
    }
}
