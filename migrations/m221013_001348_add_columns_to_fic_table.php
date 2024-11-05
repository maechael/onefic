<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fic}}`.
 */
class m221013_001348_add_columns_to_fic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fic}}', 'contact_person', $this->string(128)->after('latitude'));
        $this->addColumn('{{%fic}}', 'email', $this->string(128)->after('contact_person'));
        $this->addColumn('{{%fic}}', 'contact_number', $this->string(32)->after('email'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fic}}', 'contact_person');
        $this->dropColumn('{{%fic}}', 'email');
        $this->dropColumn('{{%fic}}', 'contact_number');
    }
}
