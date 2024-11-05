<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer_type}}`.
 */
class m220118_033657_create_customer_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer_type}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(255)->notNull()->unique()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%customer_type}}');
    }
}
