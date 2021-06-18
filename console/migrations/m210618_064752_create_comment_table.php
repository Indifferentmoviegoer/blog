<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comment}}`.
 */
class m210618_064752_create_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'comment';
        if ($this->db->getTableSchema($tableName, true) === null) {
            $this->createTable(
                '{{%comment}}',
                [
                    'id' => $this->primaryKey(),
                    'user_id' => $this->integer()->notNull(),
                    'news_id' => $this->integer(),
                    'picture_id' => $this->integer(),
                    'text' => $this->text()->notNull(),
                    'moderation' => $this->boolean()->notNull()->defaultValue(0),
                    'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')->notNull(),
                ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comment}}');
    }
}
