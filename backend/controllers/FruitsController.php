<?php

namespace backend\controllers;

use common\models\FruitsGenerator;
use PHPUnit\Exception;
use Yii;
use common\models\Fruits;
use common\models\FruitsSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class FruitsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Fruits models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FruitsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGen()
    {
        $gen=new FruitsGenerator();

        $transaction=Yii::$app->db->beginTransaction();

        try {
            $key='success';
            $msg='Фрукты успешно сгенерированы';
            $gen->generate();

            $transaction->commit();
        } catch (\yii\db\Exception $e) {
            $transaction->rollBack();

            $key='error';
            $msg='При выполнении действия возникла ошибка';
        }

        Yii::$app->session->addFlash($key,$msg);
        return $this->redirect(['index']);
    }

    public function actionEat($id, $num)
    {
        $fruit = $this->findModel($id);

        try {
            $fruit->eat($num);

            $key='success';

            if($fruit->isEaten()) {
                $msg='Фрукт был съеден...';
                $fruit->delete();
            } else {
                $msg='Фрукт был надкушен...';
                $fruit->save();
            }

        } catch (\Exception $e) {

            $key='error';
            $msg=$e->getMessage();
        }

        Yii::$app->session->addFlash($key ,$msg);
        return $this->redirect(['index']);
    }

    public function actionFall($id)
    {
        $fruit = $this->findModel($id);

        try {
            $key='success';
            $msg='Фрукт упал на землю...';

            $fruit->fall();
            $fruit->save();
        } catch (\Exception $e) {

            $key='error';
            $msg=$e->getMessage();
        }

        Yii::$app->session->addFlash($key,$msg);
        return $this->redirect(['index']);
    }

    /**
     * Finds the Fruits model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fruits the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fruits::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
