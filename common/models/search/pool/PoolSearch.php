<?php

namespace common\models\search\pool;

use common\models\pool\Pool;
use yii\data\ActiveDataProvider;

/**
 * LotoPocketSearch represents the model behind the search form about `common\models\pool\Pool`.
 */
class PoolSearch extends Pool
{
	public function rules()
	{
		return [
			[['id', 'created_at'], 'integer'],
			[['name'], 'safe'],
		];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = ['id', 'name'];

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
        $query = Pool::find();

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
            'id' 			=> $this->id,
            'updated_at' 	=> $this->updated_at,
            'created_at' 	=> $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
