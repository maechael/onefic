<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment_type}}`.
 */
class m211201_012240_create_equipment_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_type}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%equipment_type}}');
    }
}
