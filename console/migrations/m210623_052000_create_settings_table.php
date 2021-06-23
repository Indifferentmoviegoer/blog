<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m210623_052000_create_settings_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey()->notNull(),
            'name'=>$this->string(30)->notNull()->unique(),
            'value'=>$this->json()->notNull()
        ]);

        $this->insert('{{%settings}}', [
            'name' => 'phone',
            'value' => [
                'type'=>'string',
                'label'=>'Контактный номер',
                'value'=>'89999999999',
                'default'=>'89999999999'
            ]
        ]);

        $this->insert('{{%settings}}', [
            'name' => 'email',
            'value' => [
                'type'=>'string',
                'label'=>'E-mail',
                'value'=>'i.voloshenko@ddemo.ru',
                'default'=>'i.voloshenko@ddemo.ru'
            ]
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
    }
}
