<?php

use yii\db\Migration;

/**
 * Class m180930_194309_alter_table_add_fields
 */
class m180930_194309_alter_table_add_fields extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%products}}','views',$this->integer()->defaultValue(0));
        $this->addColumn('{{%categories}}','views',$this->integer()->defaultValue(0));
    }

    public function safeDown()
    {
        $this->dropColumn('{{%products}}','views');
        $this->dropColumn('{{%categories}}','views');
    }


}
