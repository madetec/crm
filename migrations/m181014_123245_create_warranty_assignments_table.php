<?php

use yii\db\Migration;

/**
 * Handles the creation of table `warranty_assignments`.
 */
class m181014_123245_create_warranty_assignments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%warranty_assignments}}', [
            'id' => $this->primaryKey(),
            'warranty_id' => $this->integer()->notNull(),
            'params' => $this->text(),
            'created_at' => $this->integer(),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%warranty_assignments}}');
    }
}
