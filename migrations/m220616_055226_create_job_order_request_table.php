<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%job_order_request}}`.
 */
class m220616_055226_create_job_order_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%job_order_request}}', [
            'id' => $this->primaryKey(),
            'fic_id' =>  $this->integer(),
            'request_type' => $this->string()->notNull(),
            'requestor' => $this->string(),
            'requestor_contact' => $this->string(),
            'requestor_profile_id' => $this->integer(),
            'request_description' => $this->text(),
            'request_date' => $this->date()->notNull(),
            'status' => $this->integer()->defaultValue(0),
            'date_approved' => $this->date(),
            'request_approved_by' => $this->string(),
            'request_noted_by' => $this->string(),
            'request_personnel_in_charge' => $this->string(),
            'date_accomplished' => $this->date(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->append('ON UPDATE CURRENT_TIMESTAMP')
        ]);

        $this->createIndex(
            '{{%idx-job_order_request-fic_id}}',
            '{{%job_order_request}}',
            'fic_id'
        );

        $this->addForeignKey(
            '{{%fk-job_order_request-fic_id}}',
            '{{%job_order_request}}',
            'fic_id',
            '{{%fic}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-job_order_request-requestor_profile_id}}',
            '{{%job_order_request}}',
            'requestor_profile_id'
        );

        $this->addForeignKey(
            '{{%fk-job_order_request-requestor_profile_id}}',
            '{{%job_order_request}}',
            'requestor_profile_id',
            '{{%user_profile}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-job_order_request-fic_id}}',
            '{{%job_order_request}}'
        );

        $this->dropIndex(
            '{{%idx-job_order_request-fic_id}}',
            '{{%job_order_request}}'
        );

        $this->dropForeignKey(
            '{{%fk-job_order_request-requestor_profile_id}}',
            '{{%job_order_request}}'
        );

        $this->dropIndex(
            '{{%idx-job_order_request-requestor_profile_id}}',
            '{{%job_order_request}}'
        );

        $this->dropTable('{{%job_order_request}}');
    }
}
