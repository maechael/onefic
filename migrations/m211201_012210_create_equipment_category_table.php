<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_category}}`.
 */
class m211201_012210_create_equipment_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%equipment_category}}');
    }
}
