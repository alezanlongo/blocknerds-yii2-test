<?php

use yii\db\Migration;

/**
 * Class m210421_183822_collection
 */
class m210421_183822_collection extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;

        $this->createTable('collection', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'image' => $this->string(255)->notNull(),
            'title' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('collection');
    }
}
