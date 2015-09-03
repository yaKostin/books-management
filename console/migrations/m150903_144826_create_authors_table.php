<?php

use yii\db\Migration;

class m150903_144826_create_authors_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%authors}}', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(64)->notNull(),
            'lastname' => $this->string(64)->notNull()
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%authors}}');
    }
}