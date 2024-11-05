<?php

use yii\db\Migration;

/**
 * Class m221122_075245_create_equipment_issue_repair
 */
class m221122_075245_create_equipment_issue_repair_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment_issue_repair}}', [
            'id' => $this->primaryKey(),
            'global_id' =>  $this->string()->notNull(),
            'equipment_issue_id' => $this->integer()->notNull(),
            'repair_activity' => $this->text()->notNull(),
            'performed_by' => $this->string(128)->notNull(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx-equipment_issue_repair-global_id', '{{%equipment_issue_repair}}', 'global_id');

        $this->createIndex('idx-equipment_issue_repair-equipment_issue_id', '{{%equipment_issue_repair}}', 'equipment_issue_id');
        $this->addForeignKey('fk-equipment_issue_repair-equipment_issue_id', '{{%equipment_issue_repair}}', 'equipment_issue_id', '{{%equipment_issue}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-equipment_issue_repair-global_id', '{{%equipment_issue_repair}}');

        $this->dropForeignKey('fk-equipment_issue_repair-equipment_issue_id', '{{%equipment_issue_repair}}');
        $this->dropIndex('idx-equipment_issue_repair-equipment_issue_id', '{{%equipment_issue_repair}}');

        $this->dropTable('{{%equipment_issue_repair}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m221122_075245_create_equipment_issue_repair cannot be reverted.\n";

        return false;
    }
    */
}
