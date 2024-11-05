<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%supplier}}`.
 */
class m220919_063226_drop_approval_status_column_from_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%supplier}}', 'approval_status');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%supplier}}', 'approval_status', $this->integer()->defaultValue(1)->after('certificate_ref_num'));
    }
}
