<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fic_service}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%fic}}`
 * - `{{%service}}`
 */
class m220118_010832_create_junction_fic_and_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fic_service}}', [
            'fic_id' => $this->integer(),
            'service_id' => $this->integer(),
            'PRIMARY KEY(fic_id, service_id)',
        ]);

        // creates index for column `fic_id`
        $this->createIndex(
            '{{%idx-fic_service-fic_id}}',
            '{{%fic_service}}',
            'fic_id'
        );

        // add foreign key for table `{{%fic}}`
        $this->addForeignKey(
            '{{%fk-fic_service-fic_id}}',
            '{{%fic_service}}',
            'fic_id',
            '{{%fic}}',
            'id',
            'CASCADE'
        );

        // creates index for column `service_id`
        $this->createIndex(
            '{{%idx-fic_service-service_id}}',
            '{{%fic_service}}',
            'service_id'
        );

        // add foreign key for table `{{%service}}`
        $this->addForeignKey(
            '{{%fk-fic_service-service_id}}',
            '{{%fic_service}}',
            'service_id',
            '{{%service}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%fic}}`
        $this->dropForeignKey(
            '{{%fk-fic_service-fic_id}}',
            '{{%fic_service}}'
        );

        // drops index for column `fic_id`
        $this->dropIndex(
            '{{%idx-fic_service-fic_id}}',
            '{{%fic_service}}'
        );

        // drops foreign key for table `{{%service}}`
        $this->dropForeignKey(
            '{{%fk-fic_service-service_id}}',
            '{{%fic_service}}'
        );

        // drops index for column `service_id`
        $this->dropIndex(
            '{{%idx-fic_service-service_id}}',
            '{{%fic_service}}'
        );

        $this->dropTable('{{%fic_service}}');
    }
}
