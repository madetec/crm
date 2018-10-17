<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_products`.
 */
class m181015_075707_create_order_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropForeignKey('{{%fk-orders-product_id}}', '{{%orders}}');
        $this->dropIndex('{{%idx-orders-product_id}}', '{{%orders}}');
        $this->dropColumn('{{%orders}}', 'product_id');
        $this->dropColumn('{{%orders}}', 'quantity');

        $this->createTable('{{%order_products}}', [
            'order_id' => $this->integer()->notNull(),
            'product_id' => $this->integer()->notNull(),
            'quantity' => $this->integer()->defaultValue(1),
        ]);

        $this->createIndex('{{%idx-order_products-product_id}}', '{{%order_products}}', ['order_id', 'product_id'], ['order_id', 'product_id']);
        $this->addForeignKey('{{%fk-order_products-product_id}}', '{{%order_products}}', 'product_id', '{{%products}}', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%order_products}}');

        $this->addColumn('{{%orders}}', 'quantity', $this->integer()->defaultValue(1));
        $this->addColumn('{{%orders}}', 'product_id', $this->integer()->notNull());
        $this->createIndex('{{%idx-orders-product_id}}', '{{%orders}}', 'product_id');
        $this->addForeignKey('{{%fk-orders-product_id}}', '{{%orders}}', 'product_id', '{{%products}}', 'id', 'RESTRICT', 'NO ACTION');
    }
}
