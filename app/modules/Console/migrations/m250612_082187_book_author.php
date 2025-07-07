<?php

use yii\db\Migration;

class m250612_082187_book_author extends Migration
{
    public string $tableName = 'book';
    public string $fkBookAuthor = 'fk_book_author-id';

    public function safeUp()
    {
        $this->createTable('{{%book_author}}', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'book_id' => $this->integer()->notNull(),
            'date_created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('{{%idx-book_author-author_id}}', '{{%book_author}}', 'book_id');

        $this->addForeignKey('fk_book_author_author_id', '{{%book_author}}', 'author_id', 'author', 'id', 'CASCADE');
        $this->addForeignKey('fk_book_author_book_id', '{{%book_author}}', 'book_id', 'book', 'id', 'CASCADE');
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk_book_author_author_id', '{{%book_author}}');
        $this->dropForeignKey('fk_book_author_book_id', '{{%book_author}}');
        $this->dropTable('{{%book_author}}');
    }
}
