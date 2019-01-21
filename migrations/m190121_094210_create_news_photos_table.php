<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news_photos`.
 */
class m190121_094210_create_news_photos_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%news_photos}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'file' => $this->string()->notNull(),
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-news_photos-product_id}}', '{{%news_photos}}', 'news_id');
        $this->addForeignKey('{{%fk-news_photos-product_id}}', '{{%news_photos}}', 'news_id', '{{%news}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%news_photos}}');
    }
}
