<?php

use yii\db\Migration;

/**
 * Handles the creation of table `alter_column_order_products`.
 */
class m190103_085539_create_alter_column_order_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%order_products}}','quantity',$this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%order_products}}','quantity',$this->integer());
    }
}
