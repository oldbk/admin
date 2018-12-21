<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\loto\LotoExport;

/**
 * LotoExportSearch represents the model behind the search form about `common\models\loto\LotoExport`.
 */
class LotoExportSearch extends LotoExport
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pocket_id', 'user_id', 'loto_num', 'exported_at'], 'integer'],
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
        $query = LotoExport::find()
            ->with(['user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'exported_at' => SORT_DESC,
                ]
            ],
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
            'pocket_id' => $this->pocket_id,
            'user_id' => $this->user_id,
            'loto_num' => $this->loto_num,
            'exported_at' => $this->exported_at,
        ]);

        return $dataProvider;
    }
}
