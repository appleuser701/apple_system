<?php

namespace common\models;


class FruitsGenerator
{
    const STATUS_FELL = 'FELL';

    public $minCount=3;
    public $maxCount=20;

    // кол-во объектов
    public $count;

    // список цветов
    public $colorList=[];

    // список статусов
    public $statusList=[];

    // список типов фруктов
    public $typeList=[];

    public function __construct()
    {
        $this->count=rand($this->minCount, $this->maxCount);

        $this->colorList=Colors::find()->select(['id'])
            ->orderBy('id')->indexBy('id')->column();

        $this->statusList=FruitStatus::find()->select(['code','id'])
            ->orderBy('id')->indexBy('id')->column();

        $this->typeList=FruitTypes::find()->select(['id'])
            ->orderBy('id')->indexBy('id')->column();
    }

    public function setCount($num)
    {
        $num=(int)$num;

        if($num>=$this->maxCount && $num<=$this->maxCount)
        {
            $this->count = $num;
        }
    }

    public function generate()
    {
        Fruits::deleteAll();

        for($i=1; $i<=$this->count; $i++) {

            $fruit = new Fruits();

            $fruit->size = 100;

            $fruit->status_id = $this
                ->getRandomStatus();

            $fruit->type_id = $this
                ->getRandomType();

            $fruit->color_id = $this
                ->getRandomColor();

            $fruit->appearance_time = $this
                ->getRandomTime();

            $regex = '/' . self::STATUS_FELL . '/i';

            if (preg_match($regex, $this->statusList[$fruit->status_id])) {
                $fruit->fall_time = $this->getFallTime($fruit->appearance_time);
            }

            $fruit->save(false);
        }

    }

    private function getRandomStatus()
    {
        return array_rand($this->statusList);
    }

    private function getRandomType()
    {
        return array_rand($this->typeList);
    }

    private function getRandomColor()
    {
        return array_rand($this->colorList);
    }

    private function getRandomTime()
    {
        $min = time() - ((mt_rand(1,1000) * 24 * 3600));
        $max = time();

        return rand($min,$max);
    }

    private function getFallTime($ctime)
    {
        return $ctime + ((mt_rand(1,10) * 24 * 3600));
    }

}