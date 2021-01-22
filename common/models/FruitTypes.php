<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fruit_types".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $storage_time
 *
 * @property Fruits[] $fruits
 */
class FruitTypes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fruit_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'storage_time'], 'required'],
            [['storage_time'], 'integer'],
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
            'storage_time' => 'Storage Time',
        ];
    }

    /**
     * Gets query for [[Fruits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFruits()
    {
        return $this->hasMany(Fruits::className(), ['type_id' => 'id']);
    }
}
