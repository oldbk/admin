<?php

namespace common\models\oldbk\search;

use common\models\oldbk\Users;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\oldbk\DilerDelo;

/**
 * DilerDeloSearch represents the model behind the search form about `common\models\oldbk\DilerDelo`.
 */
class DilerDeloSearch extends DilerDelo
{
    public $sum;
    public $date_short;

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'dilerid', 'bank', 'addition', 'order_id', 'b'], 'integer'],
            [['dilername', 'owner', 'date', 'klan', 'paysyst'], 'safe'],
            [['ekr', 'kof'], 'number'],
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
        $diler_ids = [];
        $dilers = Users::getDilers();
        foreach ($dilers as $diler) {
            $diler_ids[] = $diler->id;
        }

        $query = DilerDelo::find()
            //->select("t.*, date_format(date, \"%Y-%m-%d %H:%i\") as date_string")
            ->andWhere(['in', 'dilerid', $diler_ids])
            ->orWhere('dilerid = 8540 and b = 1 and id > 486015')
            ->andWhere('(dilerid = 8540 and klan not in ("radminion", "Adminion")) or (dilerid != 8540)')
        ;

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20
            ],
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]]
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
            'dilerid' => $this->dilerid,
            'bank' => $this->bank,
            'ekr' => $this->ekr,
            'addition' => $this->addition,
            'order_id' => $this->order_id,
            'kof' => $this->kof,
            'b' => $this->b,
            //'paysyst' => $this->paysyst
        ]);

        if($this->paysyst) {
            switch ($this->paysyst) {
                case 'robo':
                    /*$query->andFilterWhere(['in', 'paysyst',
                        ['robokassa-BankCard', 'robokassa-MobileCommerce', 'robokassa-Qiwi', 'robokassa-eInvoicing',
                        'robokassa-EMoney']
                    ]);*/
                    $query->andFilterWhere(['like', 'paysyst', 'robokassa-']);
                    break;
                case 'okpay':
                    /*$query->andFilterWhere(['in', 'paysyst',
                        ['robokassa-BankCard', 'robokassa-MobileCommerce', 'robokassa-Qiwi', 'robokassa-eInvoicing',
                        'robokassa-EMoney']
                    ]);*/
                    $query->andFilterWhere(['like', 'paysyst', 'okpay-']);
                    break;
                default:
                    $query->andFilterWhere(['=', 'paysyst', $this->paysyst]);
                    break;
            }
        }

        if($this->date) {
            $date_arr = explode('-', $this->date);
            $date_temp_1 = explode('/', trim($date_arr[0]));
            $date_temp_2 = explode('/', trim($date_arr[1]));

            $date_1 = (new \DateTime())->setDate($date_temp_1[2], $date_temp_1[1], $date_temp_1[0])
				->setTimezone(new \DateTimeZone('Europe/Moscow'))
                ->setTime(0,0);
            $date_2 = (new \DateTime())->setDate($date_temp_2[2], $date_temp_2[1], $date_temp_2[0])
				->setTimezone(new \DateTimeZone('Europe/Moscow'))
                ->setTime(23,59,59);

            $query->andWhere('date >= :date_1 and date <= :date_2', [
                ':date_1' => $date_1->format('Y-m-d H:i:s'),
                ':date_2' => $date_2->format('Y-m-d H:i:s'),
                //':date_1' => $date_1->format('Y-m-d H:i:s'),
                //':date_2' => $date_2->format('Y-m-d H:i:s')
            ]);
        }

        $query->andFilterWhere(['like', 'dilername', $this->dilername])
            ->andFilterWhere(['like', 'owner', $this->owner])
            ->andFilterWhere(['like', 'klan', $this->klan]);

        $query_sum = clone $query;
        $this->sum = $query_sum->sum('case when addition = 2 or addition = 3 or addition = 6 then ekr * 1 else ekr * kof end');

        $query
            ->select(['*', 'sum(ekr) as sum_ekr', 'date_string' => 'date_format(date, "%Y-%m-%d %H")'])
            ->groupBy(['date_string', 'owner', 'addition', 'dilername']);
        $dataProvider->totalCount = $query->count();

        return $dataProvider;
    }

    public function stats($params)
    {
        $diler_ids = [];
        $dilers = Users::getDilers();
        foreach ($dilers as $diler) {
            $diler_ids[] = $diler->id;
        }

        $query = self::find()
            ->andWhere(['in', 'dilerid', $diler_ids])
            ->orWhere('dilerid = 8540 and b = 1 and id > 486015')
            ->andWhere('(dilerid = 8540 and klan not in ("radminion", "Adminion")) or (dilerid != 8540)');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 0
            ],
            'sort' => ['defaultOrder' => ['date' => SORT_DESC]]
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
            'dilerid' => $this->dilerid,
            'bank' => $this->bank,
            'ekr' => $this->ekr,
            'addition' => $this->addition,
            'order_id' => $this->order_id,
            'kof' => $this->kof,
            'b' => $this->b,
            'paysyst' => $this->paysyst
        ]);
        if(!$this->date) {
            $this->date = sprintf('%s - %s', (new \DateTime())->modify('-1 month')->format('d/m/Y'), (new \DateTime())->format('d/m/Y'));
        }


        if($this->date) {
            $date_arr = explode('-', $this->date);
            $date_temp_1 = explode('/', trim($date_arr[0]));
            $date_temp_2 = explode('/', trim($date_arr[1]));

            $date_1 = (new \DateTime())->setDate($date_temp_1[2], $date_temp_1[1], $date_temp_1[0])
                ->setTime(0,0);
            $date_2 = (new \DateTime())->setDate($date_temp_2[2], $date_temp_2[1], $date_temp_2[0])
                ->setTime(23,59,59);

            $query->andWhere('date >= :date_1 and date <= :date_2', [
                ':date_1' => $date_1->format('Y-m-d H:i:s'),
                ':date_2' => $date_2->format('Y-m-d H:i:s')
            ]);
        }

        $query->andFilterWhere(['like', 'dilername', $this->dilername])
            ->andFilterWhere(['like', 'owner', $this->owner])
            ->andFilterWhere(['like', 'klan', $this->klan]);

        $query->select('sum(ekr) as sum, DATE_FORMAT(`date`, "%d-%m-%Y") as `date_short`')
            ->groupBy('date_short');

        return $dataProvider;
    }
}
