<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\QuestMedal;

/**
 * QuestMedalSearch represents the model behind the search form about `common\models\QuestMedal`.
 */
class QuestMedalSearch extends QuestMedal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'updated_at', 'created_at'], 'integer'],
            [['key', 'name'], 'safe'],
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
        $query = QuestMedal::find();

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
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
