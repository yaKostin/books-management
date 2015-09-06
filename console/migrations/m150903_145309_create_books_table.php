<?php

use yii\db\Migration;

class m150903_145309_create_books_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(128)->notNull(),
            // use sql query because $this->timestamp has a bug with default value initializing
            'date_create' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'date_update' => 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'preview' => $this->string(200),
            'date' => $this->date()->notNull(),
            'author_id' => $this->integer()->notNull()
        ], $tableOptions);

        $this->addForeignKey("author_id_fk", "{{%books}}", "author_id", "{{%authors}}", "id", "CASCADE");
    }

    public function down()
    {
        $this->dropTable('{{%books}}');
    }
}