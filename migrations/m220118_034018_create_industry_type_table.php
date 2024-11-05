<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%industry_type}}`.
 */
class m220118_034018_create_industry_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%industry_type}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(255)->notNull()->unique()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%industry_type}}');
    }
}
