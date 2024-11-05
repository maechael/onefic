<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%metadata}}`.
 */
class m220505_075023_add_filepath_column_to_metadata_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%metadata}}', 'filepath', $this->string()->notNull()->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%metadata}}', 'filepath');
    }
}
