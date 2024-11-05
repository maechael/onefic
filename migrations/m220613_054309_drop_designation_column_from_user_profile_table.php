<?php

use yii\db\Migration;

/**
 * Handles dropping columns from table `{{%user_profile}}`.
 */
class m220613_054309_drop_designation_column_from_user_profile_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%user_profile}}', 'designation');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('{{%user_profile}}', 'designation', $this->string(64)->after('designation_id'));
    }
}
