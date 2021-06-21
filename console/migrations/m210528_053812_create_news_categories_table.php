<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%news_categories}}`.
 */
class m210528_053812_create_news_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'news_categories';
        if ($this->db->getTableSchema($tableName, true) === null) {
            $this->createTable(
                '{{%news_categories}}',
                [
                    'id' => $this->primaryKey(),
                    'category_id' => $this->integer()->notNull(),
                    'news_id' => $this->integer()->notNull(),
                ],
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news_categories}}');
    }
}
