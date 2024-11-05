<?php

use yii\db\Migration;

/**
 * Class m220613_051025_add_designation_id_to_user_profile_table
 */
class m220613_051025_add_designation_id_to_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user_profile}}', 'designation_id', $this->integer()->after('fic_affiliation'));

        $this->createIndex(
            '{{%idx-user_profile-designation_id}}',
            '{{%user_profile}}',
            'designation_id'
        );

        $this->addForeignKey(
            '{{%fk-user_profile-designation_id}}',
            '{{%user_profile}}',
            'designation_id',
            '{{%designation}}',
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
            '{{%fk-user_profile-designation_id}}',
            '{{%user_profile}}'
        );

        $this->dropIndex(
            '{{%idx-user_profile-designation_id}}',
            '{{%user_profile}}'
        );

        $this->dropColumn('{{%user_profile}}', 'designation_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220613_051025_add_designation_id_to_user_profile_table cannot be reverted.\n";

        return false;
    }
    */
}
