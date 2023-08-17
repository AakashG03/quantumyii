<?php

use yii\db\Migration;

/**
 * Class m230816_145711_add_new_column_name_to_table_name
 */
class m230816_145711_add_new_column_name_to_table_name extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'firstname', $this->string()->defaultValue(null)->after('username'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230816_145711_add_new_column_name_to_table_name cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230816_145711_add_new_column_name_to_table_name cannot be reverted.\n";

        return false;
    }
    */
}
