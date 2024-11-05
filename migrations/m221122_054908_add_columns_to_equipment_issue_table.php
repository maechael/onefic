<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%equipment_issue}}`.
 */
class m221122_054908_add_columns_to_equipment_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment_issue}}', 'reported_by', $this->string(64)->after('status'));
        $this->addColumn('{{%equipment_issue}}', 'global_id', $this->string()->notNull()->after('id'));

        $this->createIndex('idx-equipment_issue-global_id', '{{%equipment_issue}}', 'global_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-equipment_issue-global_id', '{{%equipment_issue}}');

        $this->dropColumn('{{%equipment_issue}}', 'reported_by');
        $this->dropColumn('{{%equipment_issue}}', 'global_id');
    }
}
