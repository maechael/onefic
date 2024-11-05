<?php

use yii\db\Migration;

/**
 * Class m220817_034103_alter_supplier_table
 */
class m220817_034103_alter_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%supplier}}', 'isSupplier', $this->boolean()->defaultValue(true)->after('organization_status'));
        $this->addColumn('{{%supplier}}', 'isFabricator', $this->boolean()->defaultValue(false)->after('isSupplier'));
        $this->addColumn('{{%supplier}}', 'isDeleted', $this->boolean()->defaultValue(false)->after('isFabricator'));
        $this->alterColumn('{{%supplier}}', 'is_philgeps_registered', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%supplier}}', 'isSupplier');
        $this->dropColumn('{{%supplier}}', 'isFabricator');
        $this->dropColumn('{{%supplier}}', 'isDeleted');
        $this->alterColumn('{{%supplier}}', 'is_philgeps_registered', $this->boolean());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220817_034103_alter_supplier_table cannot be reverted.\n";

        return false;
    }
    */
}
