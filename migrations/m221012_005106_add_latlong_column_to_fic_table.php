<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%fic}}`.
 */
class m221012_005106_add_latlong_column_to_fic_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%fic}}', 'longitude', $this->decimal(20, 14)->defaultValue(0)->after('address'));
        $this->addColumn('{{%fic}}', 'latitude', $this->decimal(20, 14)->defaultValue(0)->after('longitude'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%fic}}', 'longitude');
        $this->dropColumn('{{%fic}}', 'latitude');
    }
}
