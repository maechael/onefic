<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%part}}`.
 */
class m221114_000826_add_media_id_column_to_part_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%part}}', 'media_id', $this->integer()->after('name'));

        $this->createIndex(
            '{{%idx-part-media_id}}',
            '{{%part}}',
            'media_id'
        );

        $this->addForeignKey(
            '{{%fk-part-media_id}}',
            '{{%part}}',
            'media_id',
            '{{%metadata}}',
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
            '{{%fk-part-media_id}}',
            '{{%part}}'
        );

        $this->dropIndex(
            '{{%idx-part-media_id}}',
            '{{%part}}'
        );

        $this->dropColumn('{{%part}}', 'media_id');
    }
}
