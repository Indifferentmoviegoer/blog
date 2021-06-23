<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gallery}}`.
 */
class m210526_082440_create_gallery_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'gallery';
        if ($this->db->getTableSchema($tableName, true) === null) {
            $this->createTable(
                '{{%gallery}}',
                [
                    'id' => $this->primaryKey(),
                    'name' => $this->string()->notNull(),
                    'category_id' => $this->integer()->notNull(),
                    'created_at' => $this->dateTime()->notNull(),
                    'rating' => $this->double()->notNull()->defaultValue(0),
                    'moderation' => $this->integer()->notNull()->defaultValue(0),
                ],
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%gallery}}');
    }
}
