<?php

namespace common\models\oldbk\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\oldbk\ConfigKoSettings;

/**
 * LibrarySearch represents the model behind the search form about `common\models\oldbk\ConfigKoMain`.
 */
class ConfigKoSettingsSearch extends ConfigKoSettings
{
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
        $query = ConfigKoSettings::find()
        	->joinWith('items')
			->groupBy('group_id');


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
			'config_ko_settings.main_id' => $this->main_id,
		]);

        return $dataProvider;
    }
}
