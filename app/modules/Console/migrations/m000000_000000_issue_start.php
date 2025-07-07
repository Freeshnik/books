<?php

use App\Models\User;
use yii\base\InvalidConfigException;
use yii\db\Migration;
use yii\rbac\DbManager;

class m000000_000000_issue_start extends Migration
{
    /**
     * @throws InvalidConfigException
     */
    public function safeUp(): void
    {
        $this->createTable('{{%user}}', [
            'id'                   => $this->primaryKey(),
            'username'             => $this->string()->notNull()->unique(),
            'fio'                  => $this->string(1024)->notNull(),
            'phone'                => $this->string(12)->notNull(),
            'auth_key'             => $this->string(32)->notNull(),
            'access_token'         => $this->string(16)->notNull()->unique(),
            'password_hash'        => $this->string()->notNull(),
            'password_reset_token' => $this->string()->notNull()->unique(),
            'email'                => $this->string()->notNull()->unique(),
            'type'                 => $this->smallInteger()->defaultValue(User::TYPE_GUEST),
            'status'               => $this->smallInteger()->defaultValue(User::STATUS_ACTIVE),
            'date_created'         => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'date_updated'         => $this->timestamp(),
            'date_last_visit'      => $this->timestamp(),
            'create_user_id'       => $this->integer()->null(),
        ]);

        /** @var DbManager $authManager */
        $authManager = $this->getAuthManager();

        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable($authManager->ruleTable, [
            'name' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ], $tableOptions);

        $this->createTable($authManager->itemTable, [
            'name' => $this->string(64)->notNull(),
            'type' => $this->integer()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . $authManager->ruleTable . ' (name) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $tableOptions);
        $this->createIndex('idx-auth_item-type', $authManager->itemTable, 'type');

        $this->createTable($authManager->itemChildTable, [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);

        $this->createTable($authManager->assignmentTable, [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . $authManager->itemTable . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
    }

    /**
     * @throws InvalidConfigException
     */
    public function safeDown(): void
    {
        $this->dropTable('{{%user}}');

        /** @var DbManager $authManager */
        $authManager = $this->getAuthManager();

        $this->dropTable($authManager->assignmentTable);
        $this->dropTable($authManager->itemChildTable);
        $this->dropTable($authManager->itemTable);
        $this->dropTable($authManager->ruleTable);
    }

    /**
     * @return \yii\rbac\ManagerInterface
     * @throws InvalidConfigException
     */
    protected function getAuthManager(): \yii\rbac\ManagerInterface
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }
}
