<?php

use yii\db\Migration;

/**
 * Class m220210_012725_add_fic_affiliation_to_user_profile_table
 */
class m220210_012725_add_fic_affiliation_to_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_profile}}', 'fic_affiliation', $this->integer()->after('middlename'));

        $this->createIndex('idx-user_profile-fic_affiliation', '{{%user_profile}}', 'fic_affiliation');
        $this->addForeignKey('fk-user_profile-fic_affiliation', '{{%user_profile}}', 'fic_affiliation', '{{%fic}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_profile-fic_affiliation', '{{%user_profile}}');
        $this->dropIndex('idx-user_profile-fic_affiliation', '{{%user_profile}}');

        $this->dropColumn('{{%user_profile}}', 'fic_affiliation');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220210_012725_add_fic_affiliation_to_user_profile_table cannot be reverted.\n";

        return false;
    }
    */
}
