<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%metadata}}`.
 */
class m220506_020136_add_filename_column_to_metadata_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%metadata}}', 'filename', $this->string()->notNull()->after('name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%metadata}}', 'filename');
    }
}
