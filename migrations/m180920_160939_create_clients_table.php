<?php

use yii\db\Migration;

/**
 * Handles the creation of table `clients`.
 */
class m180920_160939_create_clients_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%clients}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'last_name' => $this->string(),
            'address_line_1' => $this->string(),
            'address_line_2' => $this->string(),
            'date_of_birth' => $this->integer(),
            'phone' => $this->string(),
            'email' => $this->string(),
            'params' => $this->text(),
            'avatar' => $this->string(),
            'status' => $this->integer()->defaultValue(20),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clients}}');
    }
}
