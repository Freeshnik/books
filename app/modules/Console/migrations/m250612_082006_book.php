<?php

use yii\db\Migration;

class m250612_082006_book extends Migration
{
    public string $tableName = 'book';

    public function safeUp(): void
    {
        $this->createTable($this->tableName, [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'year' => $this->integer()->notNull()->comment('Год выпуска'),
            'description' => $this->text()->null(),
            'isbn' => $this->string()->notNull()->comment('ISBN'),
            'photo_path' => $this->string()->null()->comment('Путь фото обложки'),
            'date_created' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'date_updated' => $this->timestamp()->null(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
