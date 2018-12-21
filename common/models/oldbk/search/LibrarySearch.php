<?php

namespace common\models\oldbk\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\oldbk\LibraryCategory;

/**
 * LibrarySearch represents the model behind the search form about `common\models\oldbk\LibraryCategory`.
 */
class LibrarySearch extends LibraryCategory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','parent'], 'integer'],
            [['title'], 'safe'],
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
        $query = LibraryCategory::find()
            ->joinWith('category');


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
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        return $dataProvider;
    }
}
