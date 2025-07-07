<?php

use yii\db\Migration;

class m250613_085839_subscribe_author_table extends Migration
{
    public string $tableName = '{{%subscribe_author}}';

    public string $fkAuthor = '{{%fk_subscribe_author-author_id}}';
    public string $fkUser = 'fk_subscribe_author-user_id';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'date_created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex('idx_subscribe_author_author_id', $this->tableName, ['author_id', 'user_id'], true);

        $this->addForeignKey(
            $this->fkAuthor,
            $this->tableName,
            'author_id',
            'author',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            $this->fkUser,
            $this->tableName,
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey($this->fkAuthor, $this->tableName);
        $this->dropForeignKey($this->fkUser, $this->tableName);

        $this->dropTable($this->tableName);
    }
}
