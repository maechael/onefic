<?php

use yii\db\Migration;

/**
 * Class m220721_023922_alter_supplier_table
 */
class m220721_023922_alter_supplier_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->renameColumn('{{%supplier}}', 'name', 'organization_name');
        $this->renameColumn('{{%supplier}}', 'main_contact_celnumber', 'cellNumber');
        $this->renameColumn('{{%supplier}}', 'main_contact_email', 'email');
        $this->renameColumn('{{%supplier}}', 'main_contact_telnumber', 'telNumber');
        $this->renameColumn('{{%supplier}}', 'status', 'organization_status');
        $this->renameColumn('{{%supplier}}', 'main_contact_person', 'contact_person');
        $this->addColumn('{{%supplier}}', 'form_of_organization',  $this->string(100)->after('organization_name'));
        $this->addColumn('{{%supplier}}', 'is_philgeps_registered',  $this->boolean()->after('address'));
        $this->addColumn('{{%supplier}}', 'certificate_ref_num',  $this->string()->after('is_philgeps_registered'));
        $this->addColumn('{{%supplier}}', 'approval_status',  $this->integer()->after('certificate_ref_num'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%supplier}}', 'organization_name', 'name');
        $this->renameColumn('{{%supplier}}', 'cellNumber', 'main_contact_celnumber');
        $this->renameColumn('{{%supplier}}', 'email', 'main_contact_email');
        $this->renameColumn('{{%supplier}}', 'telNumber', 'main_contact_telnumber');
        $this->renameColumn('{{%supplier}}', 'organization_status', 'status');
        $this->renameColumn('{{%supplier}}', 'contact_person', 'main_contact_person');
        $this->dropColumn('{{%supplier}}', 'form_of_organization');
        $this->dropColumn('{{%supplier}}', 'is_philgeps_registered');
        $this->dropColumn('{{%supplier}}', 'certificate_ref_num');
        $this->dropColumn('{{%supplier}}', 'approval_status');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220721_023922_alter_supplier_table cannot be reverted.\n";

        return false;
    }
    */
}
