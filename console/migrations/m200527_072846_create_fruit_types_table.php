<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fruit_types}}`.
 */
class m200527_072846_create_fruit_types_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fruit_types}}', [
            'id' => $this->primaryKey(),

            'code'=>$this->string(50)
                ->unique()
                ->notNull(),

            'name'=>$this->string(50)
                ->unique()
                ->notNull(),

            'storage_time'=>$this->integer()
                ->notNull()
        ]);

        $this->batchInsert('{{%fruit_types}}', ['code', 'name', 'storage_time'],[
            ['apple', 'яблоко', 5 * 60 * 60 ]
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fruit_types}}');
    }
}
