<?php

use yii\db\Migration;

/**
 * Class m210428_205826_add_flag_admin_on_user_table
 */
class m210428_205826_add_flag_admin_on_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'is_admin', $this->boolean()->defaultValue(false));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210428_205826_add_flag_admin_on_user_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210428_205826_add_flag_admin_on_user_table cannot be reverted.\n";

        return false;
    }
    */
}
