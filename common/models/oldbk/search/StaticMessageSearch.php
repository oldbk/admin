<?php

namespace common\models\oldbk\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\oldbk\StaticMessage;

/**
 * StaticMessageSearch represents the model behind the search form about `common\models\oldbk\StaticMessage`.
 */
class StaticMessageSearch extends StaticMessage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_send', 'must_send', 'updated_at', 'created_at'], 'integer'],
            [['message', 'message_type'], 'safe'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = ['message_type'];

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
        $query = StaticMessage::find();

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
            'is_send' => $this->is_send,
            'must_send' => $this->must_send,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'message', $this->message])
            ->andFilterWhere(['like', 'message_type', $this->message_type]);

        return $dataProvider;
    }
}
