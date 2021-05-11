<?php

use common\models\User;
use yii\db\Migration;

/**
 * Class m210511_134356_seed_add_admin_user
 */
class m210511_134356_seed_add_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $user = \Yii::createObject([
            'class'    => User::class,
            'username' => 'admin',
            'auth_key' =>  Yii::$app->getSecurity()->generateRandomString(),
            'password' => '4dm1n2021',
            'email'    => 'admin@email.com',
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
        echo "m210511_134356_seed_add_admin_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210511_134356_seed_add_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
