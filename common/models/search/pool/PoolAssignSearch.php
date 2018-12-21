<?php

namespace common\models\search\pool;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\pool\PoolAssign;

/**
 * PoolAssignSearch represents the model behind the search form about `common\models\pool\PoolAssign`.
 */
class PoolAssignSearch extends PoolAssign
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pool_id', 'target_id', 'updated_at', 'created_at'], 'integer'],
            [['target_type', 'target_name'], 'safe'],
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
        $query = PoolAssign::find();

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
            'pool_id' => $this->pool_id,
            'target_id' => $this->target_id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'target_type', $this->target_type])
            ->andFilterWhere(['like', 'target_name', $this->target_name]);

        return $dataProvider;
    }
}
