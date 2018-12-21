<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\StatOnline;

/**
 * StatOnlineSearch represents the model behind the search form about `common\models\StatOnline`.
 */
class StatOnlineSearch extends StatOnline
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['datetime', 'updated_at'], 'integer'],
            [['count'], 'safe'],
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
        $query = StatOnline::find();

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
            'datetime' => $this->datetime,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'count', $this->count]);

        return $dataProvider;
    }
}
