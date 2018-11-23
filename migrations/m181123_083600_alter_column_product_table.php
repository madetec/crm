<?php

use yii\db\Migration;

/**
 * Class m181123_083600_alter_column_product_table
 */
class m181123_083600_alter_column_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%products}}','quantity',$this->float());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%products}}','quantity',$this->integer());

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181123_083600_alter_column_product_table cannot be reverted.\n";

        return false;
    }
    */
}
