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
        $this->createTable(
            '{{%news}}',
            [
                'id' => $this->primaryKey()->notNull(),
                'picture_id' => $this->integer()->notNull(),
                'name' => $this->string(100)->notNull(),
                'desc' => $this->string(200)->notNull(),
                'text' => $this->text()->notNull(),
                'published_at' => $this->date()->notNull(),
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%news}}');
    }

}
