<?php

namespace common\models;

use Yii;
use yii\base\Exception;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "fruits".
 *
 * @property int $id
 * @property int $size
 * @property int $status_id
 * @property int $type_id
 * @property int $color_id
 * @property int $appearance_time
 * @property int $fall_time
 *
 * @property Colors $color
 * @property FruitStatus $status
 * @property FruitTypes $type
 */
class Fruits extends \yii\db\ActiveRecord
{
    const STATUS_ON_TREE = 'STATUS_ON_TREE';
    const STATUS_FELL = 'STATUS_FELL';

    const STATE_UNKNOWN = 0;
    const STATE_HANGING = 1;
    const STATE_DROPPED = 2;
    const STATE_CORRUPT = 3;

    public $stateList = [
        self::STATE_UNKNOWN => 'Неизвестно',
        self::STATE_HANGING => 'Висячий',
        self::STATE_DROPPED => 'Упавший',
        self::STATE_CORRUPT => 'Гнилой'
    ];

    /* Текущее состояние */
    private $state;

    /* Флаги проверки состояний */
    private $hanging=0;
    private $dropped=0;
    private $corrupt=0;

    /* Сьеъден ли фрукт */
    private $eaten = 0;

    /* Флаг сортировки состояния */
    public $stateSort;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'fruits';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['size', 'status_id', 'type_id', 'color_id', 'appearance_time', 'fall_time'], 'required'],
            [['size', 'status_id', 'type_id', 'color_id', 'appearance_time', 'fall_time'], 'integer'],
            [['color_id'], 'exist', 'skipOnError' => true, 'targetClass' => Colors::className(), 'targetAttribute' => ['color_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => FruitStatus::className(), 'targetAttribute' => ['status_id' => 'id']],
            [['type_id'], 'exist', 'skipOnError' => true, 'targetClass' => FruitTypes::className(), 'targetAttribute' => ['type_id' => 'id']],
            [['state','stateSort'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'size' => 'Размер',
            'stateSort'=>'Состояние',
            'status_id' => 'Статус',
            'type_id' => 'Тип',
            'color_id' => 'Цвет',
            'appearance_time' => 'Время появления',
            'fall_time' => 'Время падения',
        ];
    }

    public function afterFind()
    {

        $this->initState();
        parent::afterFind();
    }

    public function initState()
    {
        if($this->status->code==self::STATUS_ON_TREE)
        {
            $this->state = self::STATE_HANGING;
            $this->hanging=true;
        }

        if($this->status->code==self::STATUS_FELL)
        {
            $this->state = self::STATE_DROPPED;
            $this->dropped=true;

            if(time()-$this->fall_time > $this->type->storage_time)
            {
                $this->state = self::STATE_CORRUPT;
                $this->corrupt=true;
            }
        }

        $this->stateSort=$this->state;
    }

    /**
     * Gets query for [[Color]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Colors::className(), ['id' => 'color_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(FruitStatus::className(), ['id' => 'status_id']);
    }

    /**
     * Gets query for [[Type]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(FruitTypes::className(), ['id' => 'type_id']);
    }

    public function getState()
    {
        if(key_exists($this->state, $this->stateList)) {
            return $this->stateList[$this->state];
        } else {
            return null;
        }
    }

    public function findStatus($code)
    {
        $status=FruitStatus::find()->where([
            'code'=>$code])->one();

        if($status===NULL) {
            return new NotFoundHttpException();
        }

        return $status;
    }

    // Проверка состояний
    public function isHanging()
    {
        return $this->hanging ? true : false;
    }

    public function isDropped()
    {
        return $this->dropped ? true : false;
    }

    public function isCorrupt()
    {
        return $this->corrupt ? true : false;
    }

    public function isEaten()
    {
        return $this->eaten ? true : false;
    }

    // Съесть фрукт
    public function eat($num)
    {
        $num = (int) $num;

        if(!$num) {
            $msg = 'Неккоректный процент';
            throw new Exception($msg);
        }

        if($this->isHanging()) {
            $msg = 'Невозможно съесть фрукт пока он на дереве';
            throw new Exception($msg);
        }

        if($this->isCorrupt()) {
            $msg= 'Невозможно съесть испорченный фрукт';
            throw  new Exception($msg);
        }

        if($this->size < $num) {
            $msg = 'Откушен слишком большой кусок';
            throw  new Exception($msg);
        }

        $this->size-=$num;

        if($this->size==0) {
            $this->eaten=1;
        }
    }

    // Уронить фрукт
    public function fall()
    {
        if($this->isDropped()) {
            $msg = 'Фрукт уже лежит на земле';
            throw new Exception($msg);
        }

        $status=$this->findStatus(self::STATUS_FELL);
        $this->status_id = $status->id;
        $this->fall_time = time();
    }
}
