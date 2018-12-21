<?php

namespace common\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DialogAction;

/**
 * DialogActionSearch represents the model behind the search form about `common\models\DialogAction`.
 */
class DialogActionSearch extends DialogAction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dialog_id', 'next_dialog_id', 'updated_at', 'created_at'], 'integer'],
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
        $query = DialogAction::find()
            ->with(['nextDialog']);

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
            'dialog_id' => $this->dialog_id,
            'next_dialog_id' => $this->next_dialog_id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ]);

        return $dataProvider;
    }
}
