<?php

namespace common\models\search\event;

use common\models\event\EventWcTeam;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * EventWcSearch represents the model behind the search form about `common\models\event\EventWc`.
 */
class EventWcTeamSearch extends EventWcTeam
{
	public function rules()
	{
		return [
			[['id'], 'integer'],
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
        $query = EventWcTeam::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['name' => SORT_ASC]]
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
        ]);

		$query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
