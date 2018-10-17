<?php

use yii\db\Migration;

/**
 * Handles the creation of table `warranties`.
 */
class m181014_123204_create_warranties_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%warranties}}', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer()->notNull(),
            'expired_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('{{%idx-warranties-client_id}}','{{%warranties}}','client_id');
        $this->addForeignKey('{{%fk-warranties-client_id}}','{{%warranties}}','client_id','{{%clients}}','id','RESTRICT','NO ACTION');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%warranties}}');
    }
}
