<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%customer}}`.
 */
class m220202_065528_create_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%customer}}', [
            'id' => $this->primaryKey(),
            'customer_code' => $this->string()->notNull(),
            'customer_type_id' => $this->integer()->notNull(),
            'industry_type_id' => $this->integer()->notNull(),
            'customer_name' => $this->string()->notNull(),
            'location' => $this->string(),
            'municipality_city_id' => $this->integer(),
            'province_id' => $this->integer(),
            'region_id' => $this->integer(),
            'date_registered' => $this->timestamp()
        ]);

        $this->createIndex('idx-customer-customer_type_id', '{{%customer}}', 'customer_type_id');
        $this->addForeignKey('fk-customer-customer_type_id', '{{%customer}}', 'customer_type_id', '{{%customer_type}}', 'id', 'CASCADE');

        $this->createIndex('idx-customer-industry_type_id', '{{%customer}}', 'industry_type_id');
        $this->addForeignKey('fk-customer-industry_type_id', '{{%customer}}', 'industry_type_id', '{{%industry_type}}', 'id', 'CASCADE');

        $this->createIndex('idx-customer-municipality_city_id', '{{%customer}}', 'municipality_city_id');
        $this->addForeignKey('fk-customer-municipality_city_id', '{{%customer}}', 'municipality_city_id', '{{%municipality_city}}', 'id', 'CASCADE');

        $this->createIndex('idx-customer-province_id', '{{%customer}}', 'province_id');
        $this->addForeignKey('fk-customer-province_id', '{{%customer}}', 'province_id', '{{%province}}', 'id', 'CASCADE');

        $this->createIndex('idx-customer-region_id', '{{%customer}}', 'region_id');
        $this->addForeignKey('fk-customer-region_id', '{{%customer}}', 'region_id', '{{%region}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-customer-province_id', '{{%customer}}');
        $this->dropIndex('idx-customer-province_id', '{{%customer}}');

        $this->dropForeignKey('fk-customer-municipality_city_id', '{{%customer}}');
        $this->dropIndex('idx-customer-municipality_city_id', '{{%customer}}');

        $this->dropForeignKey('fk-customer-industry_type_id', '{{%customer}}');
        $this->dropIndex('idx-customer-industry_type_id', '{{%customer}}');

        $this->dropForeignKey('fk-customer-customer_type_id', '{{%customer}}');
        $this->dropIndex('idx-customer-customer_type_id', '{{%customer}}');

        $this->dropForeignKey('fk-customer-region_id', '{{%customer}}');
        $this->dropIndex('idx-customer-region_id', '{{%customer}}');

        $this->dropTable('{{%customer}}');
    }
}
