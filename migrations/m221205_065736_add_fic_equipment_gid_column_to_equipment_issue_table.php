<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%equipment_issue}}`.
 */
class m221205_065736_add_fic_equipment_gid_column_to_equipment_issue_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%equipment_issue}}', 'fic_equipment_gid', $this->string()->notNull()->after('global_id'));

        $this->createIndex('idx-equipment_issue-fic_equipment_gid', '{{%equipment_issue}}', 'fic_equipment_gid');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-equipment_issue-fic_equipment_gid', '{{%equipment_issue}}');

        $this->dropColumn('{{%equipment_issue}}', 'fic_equipment_gid');
    }
}
