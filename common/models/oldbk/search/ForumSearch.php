<?php

namespace common\models\oldbk\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\oldbk\Forum;

/**
 * WordfilterSearch represents the model behind the search form about `\common\models\oldbk\Wordfilter`.
 */
class ForumSearch extends Forum
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','type', 'parent', 'author', 'close', 'closepal', 'icon', 'del_top', 'delpal', 'deltoppal', 'ok', 'vote', 'only_own', 'is_closed'], 'integer'],
            [['a_info','topic','text'], 'safe'],
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
        $query = Forum::find();

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

        $query->andFilterWhere(['like', 'a_info', $this->a_info]);
        $query->andFilterWhere(['like', 'text', $this->text]);

        return $dataProvider;
    }
}
