<?php

namespace frontend\modules\export\controllers;

use frontend\components\AuthController;
use frontend\models\export\Email;
use Yii;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for LibraryCategory model.
 */
class EmailController extends AuthController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all LibraryCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
		$model = new Email();
		if($model->load(Yii::$app->request->post()) && $model->validate()) {
			header('Content-Type: text/csv; charset=utf-8');
			header('Content-Disposition: attachment; filename=email.csv');
			$output = fopen('php://output', 'w');

			$date = (new \DateTime())->modify('-'.$model->last_enter.' day');

			$builder = (new \yii\db\Query())
				->select("u.email")
				->from(['u' => 'users'])
				->join('left join', ['i' => 'iplog'], 'i.owner = u.id and i.date > :date', [':date' => $date->getTimestamp()])
				->where('u.level >= :level and i.id is null and u.email != ""', [':level' => $model->level])
				->groupBy('u.email');

			$rows = $builder->all(Yii::$app->db_oldbk);

			foreach ($rows as $item) {
				if(strpos($item['email'], '@') === false) {
					continue;
				}

				fputcsv($output, $item);
			}

			exit;
		}

        return $this->render('index', [
            'model' => $model,
        ]);
    }
}
