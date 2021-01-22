<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fruit_states}}`.
 */
class m200527_073616_create_fruit_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fruit_status}}', [
            'id' => $this->primaryKey(),

            'code'=>$this->string(50)
                ->unique()
                ->notNull(),

            'name'=>$this->string(50)
                ->unique()
                ->notNull(),
        ]);

        $this->batchInsert('{{%fruit_status}}', ['code', 'name'],[
            ['STATUS_ON_TREE', 'На дереве'],
            ['STATUS_FELL', 'Упало'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fruit_status}}');
    }
}
