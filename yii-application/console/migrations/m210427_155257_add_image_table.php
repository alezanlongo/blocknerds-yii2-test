<?php

use yii\db\Migration;

/**
 * Class m210427_155257_add_image_table
 */
class m210427_155257_add_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = null;

        $this->createTable('image', [
            'id' => $this->primaryKey(),
            'collection_id' => $this->integer()->notNull(),
            'author' => $this->string(),
            'description' => $this->string(),
            'url' => $this->string(255)->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_by' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('image');
    }
}
