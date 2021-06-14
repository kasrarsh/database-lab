<?php

use yii\db\Migration;

/**
 * Class m210612_173249_add_role_to_user
 */
class m210612_173249_add_role_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}','role',$this->integer()->after('status'));
        $this->addColumn('{{%user}}','name',$this->string()->after('username'));
        $this->addColumn('{{%user}}','dept_name',$this->string());
        $this->addColumn('{{%user}}','salary',$this->integer());
        $this->addColumn('{{%user}}','tot_cred',$this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn("{{%user}}","role");
        $this->dropColumn("{{%user}}","name");
        $this->dropColumn("{{%user}}","dept_name");
        $this->dropColumn("{{%user}}","salary");
        $this->dropColumn("{{%user}}","tot_cred");
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210612_173249_add_role_to_user cannot be reverted.\n";

        return false;
    }
    */
}
