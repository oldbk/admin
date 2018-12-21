<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RateManager;

/**
 * RateManagerSearch represents the model behind the search form about `common\models\RateManager`.
 */
class RateManagerSearch extends RateManager
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'reward_till_days', 'updated_at', 'created_at'], 'integer'],
            [['rate_key', 'name', 'description', 'icon', 'link', 'link_encicl', 'is_enabled', 'iteration'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = RateManager::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'reward_till_days' => $this->reward_till_days,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'rate_key', $this->rate_key])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'link_encicl', $this->link_encicl])
            ->andFilterWhere(['like', 'is_enabled', $this->is_enabled])
            ->andFilterWhere(['like', 'iteration', $this->iteration]);

        return $dataProvider;
    }
}
