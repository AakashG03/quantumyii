<?php

use yii\db\Migration;

/**
 * Class m230816_155606_add_new_column_names_to_table_name
 */
class m230816_155606_add_new_column_names_to_table_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'lastname', $this->string()->defaultValue(null)->after('firstname'));
        $this->addColumn('{{%user}}', 'remember_me', $this->boolean()->defaultValue(null)->after('email'));
        $this->addColumn('{{%user}}', 'country_code', $this->smallInteger()->defaultValue(null)->after('remember_me'));
        $this->addColumn('{{%user}}', 'phone_number', $this->integer()->defaultValue(null)->after('country_code'));
        $this->addColumn('{{%user}}', 'resume_doc', $this->string()->defaultValue(null)->after('phone_number'));
        $this->addColumn('{{%user}}', 'portfolio_url', $this->string()->defaultValue(null)->after('resume_doc'));
        $this->addColumn('{{%user}}', 'preffered_job_roles', $this->string()->defaultValue(null)->after('portfolio_url'));
        $this->addColumn('{{%user}}', 'employee_referral_name', $this->string()->defaultValue(null)->after('preffered_job_roles'));
        $this->addColumn('{{%user}}', 'send_job_updates', $this->boolean()->defaultValue(null)->after('employee_referral_name'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230816_155606_add_new_column_names_to_table_name cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230816_155606_add_new_column_names_to_table_name cannot be reverted.\n";

        return false;
    }
    */
}
