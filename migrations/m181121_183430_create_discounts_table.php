<?php

use yii\db\Migration;

/**
 * Handles the creation of table `discounts`.
 */
class m181121_183430_create_discounts_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%discounts}}', [
            'id' => $this->primaryKey(),
            'photo' => $this->string(),
            'title' => $this->string()->notNull(),
            'description' => $this->string(),
            'slug' => $this->string()->notNull(),
            'text' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'expired_at' => $this->integer()->notNull(),
            'published_at' => $this->integer()->notNull(),
            'status' => $this->integer(),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%discounts}}');
    }
}
