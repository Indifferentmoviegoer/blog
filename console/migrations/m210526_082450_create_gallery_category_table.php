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
        $this->createTable('{{%gallery_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%gallery_category}}');
    }
}
