<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fruit_status".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 *
 * @property Fruits[] $fruits
 */
class FruitStatus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fruit_status';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code', 'name'], 'string', 'max' => 50],
            [['code'], 'unique'],
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
            'code' => 'Code',
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
        return $this->hasMany(Fruits::className(), ['status_id' => 'id']);
    }
}
