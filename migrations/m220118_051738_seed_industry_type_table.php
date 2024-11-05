<?php

use yii\db\Migration;

/**
 * Class m220118_051738_seed_industry_type_table
 */
class m220118_051738_seed_industry_type_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->upsert('{{%industry_type}}', ['type' => 'N/A'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Production'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Manufacturing'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Testing Laboratory'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Calibration'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Packaging'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Distributor'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Trading'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Oil/Gas'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Hauler'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Milling'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Mining'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Food'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Automotive'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Services'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Petrochemical'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Supplier'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Toll Road'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Corrugated Boxes'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Cement'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Drugstore'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Water Utility'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Pharmaceuticals'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Marketing'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Feedmill'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Electronics'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Hospital'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Cosmetics'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Gas Station'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Fuel'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Petroleum'], true);
        $this->upsert('{{%industry_type}}', ['type' => 'Fabrication'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%industry_type}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220118_051738_seed_industry_type_table cannot be reverted.\n";

        return false;
    }
    */
}
