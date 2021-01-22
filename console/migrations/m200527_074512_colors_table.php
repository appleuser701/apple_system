<?php

use yii\db\Migration;

/**
 * Class m200527_074512_colors_table
 */
class m200527_074512_colors_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%colors}}', [
            'id' => $this->primaryKey(),

            'hex_code'=>$this->string(6)
                ->unique()
                ->notNull(),

            'str_code'=>$this->string(50)
                ->unique()
                ->notNull(),

            'name'=>$this->string(50)
                ->unique()
                ->notNull(),
        ]);

        $this->batchInsert('{{%colors}}', ['hex_code', 'str_code', 'name'],[
            ['34C056', 'green', 'зеленый'],
            ['ff0000', 'red', 'красный'],
            ['ffff00', 'yellow', 'желтый'],
            ['ffd41c','orange', 'оранжевый'],
            ['ffc0cb','pink', 'розовый'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%colors}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200527_074512_colors_table cannot be reverted.\n";

        return false;
    }
    */
}
