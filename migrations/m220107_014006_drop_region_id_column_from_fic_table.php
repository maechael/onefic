<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%fic}}`.
 */
class m220107_014006_drop_region_id_column_from_fic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('fk-fic-region_id', '{{%fic}}');
        $this->dropIndex('idx-fic-region_id', '{{%fic}}');

        $this->dropColumn('{{%fic}}', 'region_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%fic}}', 'region_id', $this->integer()->notNull());

        $this->addForeignKey('fk-fic-region_id', '{{%fic}}', 'region_id', '{{%region}}', 'id', 'CASCADE');
        $this->createIndex('idx-fic-region_id', '{{%fic}}', 'region_id');
    }
}
