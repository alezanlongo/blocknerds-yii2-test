<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m210427_132944_add_admin_user
 */
class m210427_132944_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $user = \Yii::createObject([
            'class'    => User::class,
            'username' => 'admin',
            'auth_key' => '12345678',
            'password' => '12345678',
            'email'    => 'admin@@example.com',
            'status' => 10,
            'is_admin' => 1,
        ]);
        $user->insert();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210427_132944_add_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210427_132944_add_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
