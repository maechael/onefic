<?php

use yii\db\Migration;

/**
 * Class m211122_063117_insert_values_to_region
 */
class m211122_063117_insert_values_to_region extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->upsert('{{%region}}', ['id' => 1, 'number' => 15, 'name' => 'NCR', 'description' => 'National Capital Region'], true);
        $this->upsert('{{%region}}', ['id' => 2, 'number' => 16, 'name' => 'CAR', 'description' => 'Cordillera Administrative Region'], true);
        $this->upsert('{{%region}}', ['id' => 3, 'number' => 1, 'name' => 'Region I', 'description' => 'Ilocos Region'], true);
        $this->upsert('{{%region}}', ['id' => 4, 'number' => 2, 'name' => 'Region II', 'description' => 'Cagayan Valley'], true);
        $this->upsert('{{%region}}', ['id' => 5, 'number' => 3, 'name' => 'Region III', 'description' => 'Central Luzon'], true);
        $this->upsert('{{%region}}', ['id' => 6, 'number' => 4, 'name' => 'Region IV-A', 'description' => 'CALABARZON'], true);
        $this->upsert('{{%region}}', ['id' => 7, 'number' => 4, 'name' => 'Region IV-B', 'description' => 'MIMAROPA'], true);
        $this->upsert('{{%region}}', ['id' => 8, 'number' => 5, 'name' => 'Region V', 'description' => 'Bicol Region'], true);
        $this->upsert('{{%region}}', ['id' => 9, 'number' => 6, 'name' => 'Region VI', 'description' => 'Western Visayas'], true);
        $this->upsert('{{%region}}', ['id' => 10, 'number' => 7, 'name' => 'Region VII', 'description' => 'Central Visayas'], true);
        $this->upsert('{{%region}}', ['id' => 11, 'number' => 8, 'name' => 'Region VIII', 'description' => 'Eastern Visayas'], true);
        $this->upsert('{{%region}}', ['id' => 12, 'number' => 9, 'name' => 'Region IX', 'description' => 'Zamboanga Peninsula'], true);
        $this->upsert('{{%region}}', ['id' => 13, 'number' => 10, 'name' => 'Region X', 'description' => 'Northern Mindanao'], true);
        $this->upsert('{{%region}}', ['id' => 14, 'number' => 11, 'name' => 'Region XI', 'description' => 'Davao Region'], true);
        $this->upsert('{{%region}}', ['id' => 15, 'number' => 12, 'name' => 'Region XII', 'description' => 'SOCCSKSARGEN'], true);
        $this->upsert('{{%region}}', ['id' => 16, 'number' => 13, 'name' => 'Region XIII', 'description' => 'CARAGA'], true);
        $this->upsert('{{%region}}', ['id' => 17, 'number' => 14, 'name' => 'BARMM', 'description' => 'Bangsamoro'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('{{%region}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m211122_063117_insert_values_to_region cannot be reverted.\n";

        return false;
    }
    */
}
