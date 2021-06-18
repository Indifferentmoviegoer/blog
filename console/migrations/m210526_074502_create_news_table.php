<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news}}`.
 */
class m210526_074502_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'news';
        if ($this->db->getTableSchema($tableName, true) === null) {
            $this->createTable(
                '{{%news}}',
                [
                    'id' => $this->primaryKey()->notNull(),
                    'picture_id' => $this->integer()->notNull(),
                    'name' => $this->string(150)->notNull(),
                    'desc' => $this->string(250)->notNull(),
                    'text' => $this->text()->notNull(),
                    'published_at' => $this->dateTime()->notNull(),
                    'forbidden' => $this->boolean()->notNull(),
                ]
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }

}
