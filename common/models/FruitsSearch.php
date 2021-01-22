<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Fruits;
use yii\data\ArrayDataProvider;

/**
 * FruitsSearch represents the model behind the search form of `common\models\Fruits`.
 */
class FruitsSearch extends Fruits
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'size', 'status_id', 'type_id', 'color_id', 'appearance_time', 'fall_time'], 'integer'],
            [['stateSort'],'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function afterFind()
    {
        parent::afterFind();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        $query = Fruits::find()->with(['type', 'status','color']);

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'size' => $this->size,
            'status_id' => $this->status_id,
            'type_id' => $this->type_id,
            'color_id' => $this->color_id,
            'appearance_time' => $this->appearance_time,
            'fall_time' => $this->fall_time,
        ]);

        $provider = new ArrayDataProvider([
            'allModels' => $dataProvider->query->all(),
            'sort' => [
                'attributes' => [
                    'id',
                    'size',
                    'status_id',
                    'stateSort',
                    'type_id',
                    'color_id',
                    'appearance_time',
                    'fall_time'
                    ],
            ],
            'totalCount'=>$dataProvider->getTotalCount(),
        ]);

        return $provider;
    }
}
