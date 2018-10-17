<?php

use yii\db\Migration;

/**
 * Class m180921_173454_create_dealer_assignments
 */
class m180921_173454_create_dealer_assignments extends Migration
{
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%dealer_assignments}}', [
            'dealer_id' => $this->integer()->notNull(),
            'client_id' => $this->integer()->notNull(),
            'percent' => $this->float()->null(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-dealer_assignments}}', '{{%dealer_assignments}}', ['dealer_id', 'client_id']);
        $this->createIndex('{{%idx-dealer_assignments-dealer_id}}', '{{%dealer_assignments}}', ['dealer_id', 'client_id'], ['dealer_id', 'client_id']);
        $this->addForeignKey('{{%fk-dealer_assignments-dealer_id}}','{{%dealer_assignments}}','dealer_id','{{%clients}}','id','RESTRICT','RESTRICT');
        $this->addForeignKey('{{%fk-dealer_assignments-client_id}}','{{%dealer_assignments}}','client_id','{{%clients}}','id','RESTRICT','RESTRICT');
    }

    public function safeDown()
    {
        $this->dropTable('{{%dealer_assignments}}');
    }
}
