<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fic}}`.
 */
class m211122_065718_add_address_column_to_fic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fic}}', 'address', $this->string(150)->after('region_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fic}}', 'address');
    }
}
