<?php

namespace common\models\oldbk\search;

use common\models\oldbk\Shop;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * search represents the model behind the search form about `common\models\QuestList`.
 */
class ShopSearch extends Shop
{
    public function rules()
    {
        return [
            [['id', 'name', 'magic', 'dressroom'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
		$scenarios = parent::scenarios();
		$scenarios[self::SCENARIO_SEARCH] = ['id', 'name', 'dressroom'];

        // bypass scenarios() implementation in the parent class
        return $scenarios;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Shop::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10
            ],
			'sort' => ['defaultOrder' => ['id' => SORT_ASC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'magic' => $this->magic,
            'dressroom' => $this->dressroom,
        ]);

        $query->andFilterWhere([
            'or',
            ['like', 'name', $this->name],
            ['id' => $this->name],
        ]);
        $query->orderBy(['name' => 'desc']);

        return $dataProvider;
    }
}
