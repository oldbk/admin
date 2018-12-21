<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\QuestPart;

/**
 * QuestPartSearch represents the model behind the search form about `common\models\QuestPart`.
 */
class QuestPartSearch extends QuestPart
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'quest_id', 'is_auto_finish', 'part_number', 'updated_at', 'created_at', 'is_deleted'], 'integer'],
            [['name', 'img', 'description_type', 'description', 'chat_start', 'chat_end'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = [];

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
        $query = QuestPart::find()
            ->active();

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
            'quest_id' => $this->quest_id,
            'is_auto_finish' => $this->is_auto_finish,
            'part_number' => $this->part_number,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'img', $this->img])
            ->andFilterWhere(['like', 'description_type', $this->description_type])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'chat_start', $this->chat_start])
            ->andFilterWhere(['like', 'chat_end', $this->chat_end]);

        return $dataProvider;
    }
}
