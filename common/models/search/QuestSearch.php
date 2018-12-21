<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Quest;

/**
 * QuestSearch represents the model behind the search form about `common\models\Quest`.
 */
class QuestSearch extends Quest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'started_at', 'ended_at', 'min_level', 'max_level', 'limit_count', 'limit_interval', 'is_enabled', 'updated_at', 'created_at', 'is_deleted'], 'integer'],
            [['quest_type', 'name', 'category_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = ['category_id', 'name'];

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
        $query = Quest::find()
            ->active()
            ->joinWith('category')
            ->orderBy('updated_at desc');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'name' => [
                    'default' => SORT_ASC
                ],
                'category_id' => [
                    'asc' => ['quest_category.name' => SORT_ASC],
                    'desc' => ['quest_category.name' => SORT_DESC],
                    'label' => 'Категория'
                ]
            ]
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
            'category_id' => $this->category_id,
            'started_at' => $this->started_at,
            'ended_at' => $this->ended_at,
            'min_level' => $this->min_level,
            'max_level' => $this->max_level,
            'limit_count' => $this->limit_count,
            'limit_interval' => $this->limit_interval,
            'is_enabled' => $this->is_enabled,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'quest.quest_type', $this->quest_type])
            ->andFilterWhere(['like', 'quest.name', $this->name]);

        return $dataProvider;
    }
}
