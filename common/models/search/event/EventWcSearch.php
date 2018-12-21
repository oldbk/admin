<?php

namespace common\models\search\event;

use common\models\event\EventWc;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * EventWcSearch represents the model behind the search form about `common\models\event\EventWc`.
 */
class EventWcSearch extends EventWc
{
	public function rules()
	{
		return [
			[['id'], 'integer'],
		];
	}

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = ['id'];

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
        $query = EventWc::find()
			->with(['team1', 'team2']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['datetime' => SORT_ASC]],
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
            'year' 			=> $this->year,
            'updated_at' 	=> $this->updated_at,
        ]);


        return $dataProvider;
    }
}
