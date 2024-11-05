<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fic_personnel}}`.
 */
class m211202_070545_create_fic_personnel_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fic_personnel}}', [
            'fic_id' => $this->integer(),
            'user_profile_id' => $this->integer()->unique(),
            'PRIMARY KEY(fic_id, user_profile_id)'
        ]);

        $this->createIndex('idx-fic_personnel-fic_id', '{{%fic_personnel}}', 'fic_id');
        $this->addForeignKey('fk-fic_personnel-fic_id', '{{%fic_personnel}}', 'fic_id', '{{%fic}}', 'id', 'CASCADE');

        $this->createIndex('idx-fic_personnel-user_profile_id', '{{%fic_personnel}}', 'user_profile_id');
        $this->addForeignKey('fk-fic_personnel-user_profile_id', '{{%fic_personnel}}', 'user_profile_id', '{{%user_profile}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-fic_personnel-fic_id', '{{%fic_personnel}}');
        $this->dropIndex('idx-fic_personnel-fic_id', '{{%fic_personnel}}');

        $this->dropForeignKey('fk-fic_personnel-user_profile_id', '{{%fic_personnel}}');
        $this->dropIndex('idx-fic_personnel-user_profile_id', '{{%fic_personnel}}');

        $this->dropTable('{{%fic_personnel}}');
    }
}
