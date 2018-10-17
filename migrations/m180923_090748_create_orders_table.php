<?php

use yii\db\Migration;

/**
 * Handles the creation of table `orders`.
 */
class m180923_090748_create_orders_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id' => $this->primaryKey(),
            'product_id' => $this->integer(),
            'client_id' => $this->integer(),
            'quantity' => $this->integer()->defaultValue(1),
            'status' => $this->integer(),
            'created_at' => $this->integer(),
        ]);

        $this->createIndex('{{%idx-orders-product_id}}','{{%orders}}','product_id');
        $this->createIndex('{{%idx-orders-client_id}}','{{%orders}}','client_id');

        $this->addForeignKey('{{%fk-orders-product_id}}','{{%orders}}','product_id','{{%products}}','id','RESTRICT','NO ACTION');
        $this->addForeignKey('{{%fk-orders-client_id}}','{{%orders}}','client_id','{{%clients}}','id','RESTRICT','NO ACTION');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
