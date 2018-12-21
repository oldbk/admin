<?php

namespace common\models\oldbk\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\oldbk\Wordfilter;

/**
 * WordfilterSearch represents the model behind the search form about `\common\models\oldbk\Wordfilter`.
 */
class WordfilterSearch extends Wordfilter
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at','updated_at','onlyfull'], 'integer'],
            [['word'], 'safe'],
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
        $query = Wordfilter::find();

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
            'onlyfull' => $this->onlyfull,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'word', $this->word]);

        return $dataProvider;
    }
}
