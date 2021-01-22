<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "colors".
 *
 * @property int $id
 * @property string $hex_code
 * @property string $str_code
 * @property string $name
 *
 * @property Fruits[] $fruits
 */
class Colors extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'colors';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['hex_code', 'str_code', 'name'], 'required'],
            [['hex_code'], 'string', 'max' => 6],
            [['str_code', 'name'], 'string', 'max' => 50],
            [['hex_code'], 'unique'],
            [['str_code'], 'unique'],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'hex_code' => 'Hex Code',
            'str_code' => 'Str Code',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[Fruits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFruits()
    {
        return $this->hasMany(Fruits::className(), ['color_id' => 'id']);
    }
}
