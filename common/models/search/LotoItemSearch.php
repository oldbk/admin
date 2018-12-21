<?php

namespace common\models\search;

use common\helper\CurrencyHelper;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\loto\LotoItem;

/**
 * LotoItemSearch represents the model behind the search form about `common\models\LotoItem`.
 */
class LotoItemSearch extends LotoItem
{
    //кол-во основных предметов без запаса
    public $count = 0;
    public $count_kr = 0;
    public $count_sum_kr = 0;
    public $count_ekr = 0;
    public $count_sum_ekr = 0;

    //сумма в кр и екр основных предметов без запаса
    public $cost_kr = 0;
    public $cost_ekr = 0;

    //себестоимость основных предметов без запаса
    public $prime_kr = 0;
    public $prime_ekr = 0;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'cost_type', 'stock', 'updated_at', 'created_at'], 'integer'],
            [['item_name', 'item_info_name', 'cost'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_SEARCH] = ['id', 'cost_type', 'stock', 'updated_at', 'created_at',
            'item_name', 'item_info_name', 'cost'];

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
        $query = LotoItem::find()
            ->with(['lotoItemInfos']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => 'cost_type asc, cost asc']
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
            'cost' => $this->cost,
            'cost_type' => $this->cost_type,
            'stock' => $this->stock,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'pocket_id' => $this->pocket_id,
        ]);

        $query->andFilterWhere(['like', 'item_name', $this->item_name]);
        $query->andFilterWhere(['like', 'item_info_name', $this->item_info_name]);

        return $dataProvider;
    }

    public function searchIndex($params)
    {

        $dataProvider = $this->search($params);

        /** @var \common\models\query\LotoItemQuery $query_main */
        $query_main = clone $dataProvider->query;

        $this->count = $query_main->count();

        $query_main->andWhere('cost_type = :cost_type');

        $query_main->params[':cost_type'] = CurrencyHelper::CURRENCY_KR;
        $this->count_kr = $query_main->count();
        $this->cost_kr = $query_main->sum('cost_sum') ?: 0;
        $this->count_sum_kr = $query_main->sum('count') ?: 0;

        $query_main->params[':cost_type'] = CurrencyHelper::CURRENCY_EKR;
        $this->count_ekr = $query_main->count();
        $this->cost_ekr = $query_main->sum('cost_sum') ?: 0;
        $this->count_sum_ekr = $query_main->sum('count') ?: 0;

        if($this->count_sum_kr) {
            $this->prime_kr = $this->cost_kr / $this->count_sum_kr;
        }
        if($this->count_sum_ekr) {
            $this->prime_ekr = $this->cost_ekr / $this->count_sum_ekr;
        }

        return $dataProvider;
    }
}
