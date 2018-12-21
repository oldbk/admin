<?php

namespace common\models\search\dialog;

use common\models\dialog\Dialog;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\dialog\DialogQuest;

/**
 * DialogSearch represents the model behind the search form about `common\models\dialog\DialogQuest`.
 */
class DialogQuestSearch extends DialogQuest
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'bot_id', 'item_id', 'is_saved', 'updated_at', 'created_at'], 'integer'],
            [['item_type', 'action_type', 'message'], 'safe'],
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = ['item_type', 'action_type', 'message'];

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
        $query = Dialog::find()
            ->with('bot')
            ->orderBy('order_position asc');

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
            'bot_id' => $this->bot_id,
            'item_id' => $this->item_id,
            'global_parent_id' => $this->global_parent_id,
            'is_saved' => $this->is_saved,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query
            //->andFilterWhere(['like', 'item_type', $this->item_type])
            ->andFilterWhere(['like', 'action_type', $this->action_type])
            ->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}
