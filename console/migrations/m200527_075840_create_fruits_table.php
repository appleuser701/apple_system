<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%fruits}}`.
 */
class m200527_075840_create_fruits_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%fruits}}', [
            'id' => $this->primaryKey(),

            'size'=>$this->tinyInteger()
                ->notNull(),

            'status_id'=>$this->integer()
                ->notNull(),

            'type_id'=>$this->integer()
                ->notNull(),

            'color_id'=>$this->integer()
                ->notNull(),

            'appearance_time'=>$this->integer()
                ->unsigned()
                ->notNull(),

            'fall_time'=>$this->integer()
                ->unsigned()
                ->null(),
        ]);

        $this->addForeignKey(
            'fk-fruits-status_id',
            "fruits",
            'status_id',
            "fruit_status",
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-fruits-type_id',
            "fruits",
            'type_id',
            "fruit_types",
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-fruits-color_id',
            "fruits",
            'color_id',
            "colors",
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%fruits}}');
    }
}
