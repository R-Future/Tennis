<?php

namespace backend\controllers;

use backend\models\searches\AwArenaSearch;
use common\models\AwArena;
use common\models\AwCity;
use common\models\AwProvince;
use common\models\AwTown;
use Yii;
use common\models\AwRegion;
use backend\models\searches\AwRegionSearch;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegionController implements the CRUD actions for AwRegion model.
 */
class RegionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AwRegion models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AwRegionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize=10;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AwRegion model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel=new AwArena();
        $dataProvider=(new AwArenaSearch())->search(Yii::$app->request->queryParams,$id);//提供该地区场馆信息 modified by Future at 17:29 19.5.2016
        $dataProvider->pagination->pageSize=5;
        return $this->render('view', [
            'model' => $this->findModel($id),
            'searchModel' =>$searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Creates a new AwRegion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AwRegion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AwRegion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AwRegion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AwRegion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AwRegion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AwRegion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $province
     * 获取选定省的所有城市
     */
    public function actionCity($province){
        $cityModel=(new AwCity())->getCityList($province);
        echo Html::tag('option',Html::encode('--请选择市--'),['value'=>'empty']);
        foreach ($cityModel as $city){
            echo Html::tag('option',Html::encode($city),array(['value'=>$city]));
        }
    }

    /**
     * @param $province
     * @param $city
     */
    public function actionTown($province,$city){
        $townModel=(new AwTown())->getTownList($province,$city);
        echo Html::tag('option',Html::encode('--请选择区县--'),['value'=>'empty']);
        foreach ($townModel as $town){
            echo Html::tag('option',Html::encode($town),array(['value'=>$city]));
        }
    }
}
