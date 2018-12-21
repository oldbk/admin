<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\recipe\Recipe;

/**
 * RecipeSearch represents the model behind the search form about `common\models\recipe\Recipe`.
 */
class RecipeSearch extends Recipe
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'time', 'category_id', 'profession_id', 'difficult', 'is_enabled', 'is_deleted', 'updated_at', 'created_at'], 'integer'],
            [['name'], 'safe'],
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
        $query = Recipe::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
	    'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
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
            'time' => $this->time,
            'category_id' => $this->category_id,
            'profession_id' => $this->profession_id,
            'difficult' => $this->difficult,
            'is_enabled' => $this->is_enabled,
            'is_deleted' => 0,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
