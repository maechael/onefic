<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%supplier}}`.
 */
class m220601_235205_create_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%supplier}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'main_contact_person' => $this->string(),
            'main_contact_celnumber' => $this->string(),
            'main_contact_email' => $this->string(),
            'main_contact_telnumber' => $this->string(),
            'region_id' => $this->integer(),
            'province_id' => $this->integer(),
            'municipality_city_id' => $this->integer(),
            'address' => $this->string(),
            'status' => $this->integer()->defaultValue(1),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex(
            '{{%idx-supplier-region_id}}',
            '{{%supplier}}',
            'region_id'
        );

        $this->addForeignKey(
            '{{%fk-supplier-region_id}}',
            '{{%supplier}}',
            'region_id',
            '{{%region}}',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            '{{%idx-supplier-province_id}}',
            '{{%supplier}}',
            'province_id'
        );

        $this->addForeignKey(
            '{{%fk-supplier-province_id}}',
            '{{%supplier}}',
            'province_id',
            '{{%province}}',
            'id',
            'SET NULL'
        );

        $this->createIndex(
            '{{%idx-supplier-municipality_city_id}}',
            '{{%supplier}}',
            'municipality_city_id'
        );

        $this->addForeignKey(
            '{{%fk-supplier-municipality_city_id}}',
            '{{%supplier}}',
            'municipality_city_id',
            '{{%municipality_city}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-supplier-region_id}}',
            '{{%supplier}}'
        );

        $this->dropIndex(
            '{{%idx-supplier-region_id}}',
            '{{%supplier}}'
        );

        $this->dropForeignKey(
            '{{%fk-supplier-province_id}}',
            '{{%supplier}}'
        );

        $this->dropIndex(
            '{{%idx-supplier-province_id}}',
            '{{%supplier}}'
        );

        $this->dropForeignKey(
            '{{%fk-supplier-municipality_city_id}}',
            '{{%supplier}}'
        );

        $this->dropIndex(
            '{{%idx-supplier-municipality_city_id}}',
            '{{%supplier}}'
        );

        $this->dropTable('{{%supplier}}');
    }
}
