<?php

use yii\db\Migration;

/**
 * Handles the creation of table `products`.
 */
class m180920_180220_create_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer(),
            'name' => $this->string()->notNull(),
            'article' => $this->string(),
            'price' => $this->float(),
            'old_price' => $this->float(),
            'params' => $this->text(),
            'quantity' => $this->integer(),
            'main_photo_id' => $this->integer(),
            'status' => $this->integer()->defaultValue(20),
        ],$tableOptions);

        $this->addForeignKey(
            '{{%fk-products-category_id}}',
            '{{%products}}',
            'category_id',
            '{{%categories}}',
            'id',
            'CASCADE',
            'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
    }
}
