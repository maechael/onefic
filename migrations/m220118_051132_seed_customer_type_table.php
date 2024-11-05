<?php

use yii\db\Migration;

/**
 * Class m220118_051132_seed_customer_type_table
 */
class m220118_051132_seed_customer_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->upsert('{{%customer_type}}', ['type' => 'Individual'], true);
        $this->upsert('{{%customer_type}}', ['type' => 'Private'], true);
        $this->upsert('{{%customer_type}}', ['type' => 'Government'], true);
        $this->upsert('{{%customer_type}}', ['type' => 'Academe'], true);
        $this->upsert('{{%customer_type}}', ['type' => 'Student'], true);
        $this->upsert('{{%customer_type}}', ['type' => 'Internal'], true);
        $this->upsert('{{%customer_type}}', ['type' => 'N/A'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%customer_type}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220118_051132_seed_customer_type_table cannot be reverted.\n";

        return false;
    }
    */
}
