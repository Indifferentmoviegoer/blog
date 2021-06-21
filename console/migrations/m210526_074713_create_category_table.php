<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%category}}`.
 */
class m210526_074713_create_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'category';
        if ($this->db->getTableSchema($tableName, true) === null) {
            $this->createTable(
                '{{%category}}',
                [
                    'id' => $this->primaryKey(),
                    'parent_id' => $this->integer()->notNull()->defaultValue(0),
                    'name' => $this->string()->notNull(),
                ],
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%category}}');
    }
}
