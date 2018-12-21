<?php

namespace frontend\controllers;

use common\models\Notepad;
use frontend\components\AuthController;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * ItemController implements the CRUD actions for LotoItem model.
 */
class NotepadController extends AuthController
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

    public function actionSave($id)
    {
        $model = $this->findModel($id);
        $model->message = Yii::$app->request->post('message');
        
        if ($model->save()) {
            return Json::encode([
                'success' => true,
            ]);
        }

        return Json::encode([
            'error' => true,
            'messages' => [
                ['title' => 'Операция завершена с ошибкой', 'text' => implode('<br>', $model->errors)]
            ]
        ]);
    }

    /**
     * Finds the LotoItem model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Notepad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Notepad::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
