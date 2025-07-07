<?php

use yii\db\Migration;

class m250612_081503_author extends Migration
{
    private string $table = 'author';

    public function safeUp(): void
    {
        $this->createTable($this->table, [
            'id' => $this->primaryKey(),
            'fio' => $this->string()->notNull(),
            'description' => $this->text()->null(),
            'date_created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'date_updated' => $this->timestamp()->null(),
        ]);
    }

    public function safeDown(): void
    {
        $this->dropTable($this->table);
    }
}
