<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%gallery_category}}`.
 */
class m210526_082450_create_gallery_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'gallery_category';
        if ($this->db->getTableSchema($tableName, true) === null) {
            $this->createTable(
                '{{%gallery_category}}',
                [
                    'id' => $this->primaryKey(),
                    'name' => $this->string()->notNull(),
                ],
                "IF NOT EXISTS"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%gallery_category}}');
    }
}
