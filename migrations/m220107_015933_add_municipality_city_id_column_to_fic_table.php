<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fic}}`.
 */
class m220107_015933_add_municipality_city_id_column_to_fic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fic}}', 'municipality_city_id', $this->integer()->after('name'));

        $this->createIndex('idx-fic-municipality_city_id', '{{%fic}}', 'municipality_city_id');
        $this->addForeignKey('fk-fic-municipality_city_id', '{{%fic}}', 'municipality_city_id', '{{%municipality_city}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-fic-municipality_city_id', '{{%fic}}');
        $this->dropIndex('idx-fic-municipality_city_id', '{{%fic}}');

        $this->dropColumn('{{%fic}}', 'municipality_city_id');
    }
}
