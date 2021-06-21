<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%picture}}`.
 */
class m210526_083617_create_picture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'picture';
        if ($this->db->getTableSchema($tableName, true) === null) {
            $this->createTable(
                '{{%picture}}',
                [
                    'id' => $this->primaryKey(),
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
        $this->dropTable('{{%picture}}');
    }
}
