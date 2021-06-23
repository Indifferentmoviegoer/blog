<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%rating}}`.
 */
class m210611_104115_create_rating_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = $this->db->tablePrefix . 'rating';
        if ($this->db->getTableSchema($tableName, true) === null) {
            $this->createTable(
                '{{%rating}}',
                [
                    'id' => $this->primaryKey(),
                    'picture_id' => $this->integer()->notNull(),
                    'ip' => $this->string()->notNull(),
                    'value' => $this->integer()->notNull()->defaultValue(0),
                ],
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%rating}}');
    }
}
