<?php

namespace frontend\modules\images\controllers;

use frontend\components\AuthController;
use Yii;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use common\models\oldbk\search\UsersSearch;
use common\models\oldbk\Users;
use common\models\oldbk\UsersShadows;
use common\models\oldbk\Eshop;
use common\models\oldbk\Gellery;
use common\helper\CategoryItemHelper;


/**
 * UserController implements the CRUD actions for User model.
 */
class PersonalController extends AuthController
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

    public function actionIndex() {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->searchUser(Yii::$app->request->queryParams);
	
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id) {
        $model = $this->findModel($id);

        $shadows = new ActiveDataProvider([
            'query' => UsersShadows::find()->where('owner  = :owner', [':owner' => $model->id]),
            'pagination' => [
                'pageSize' => -1,
            ],
        ]);


        $gifts = new ActiveDataProvider([
            'query' => Eshop::find()->where('owner  = :owner', [':owner' => $model->id]),
            'pagination' => [
                'pageSize' => -1,
            ],
        ]);

	$imdata = Gellery::getImages($model->id);
	$images = [];


	foreach($imdata as $item) {
		 $images[CategoryItemHelper::getLabel($item['otdel'])][] = $item;
	}


        return $this->render('view', [
		'model' => $model,
		'shadows' => $shadows,
		'gifts' => $gifts,
		'images' => $images,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = Users::find()->where(['id' => $id])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
