<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Base;
use frontend\models\BaseSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\libraries\LimeStringHelper;
/**
 * BaseController implements the CRUD actions for Base model.
 */
class BaseController extends Controller
{

    public  $modelPath="frontend\models\\";
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
     * Lists all Base models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BaseSearch();
        $queryParams = Yii::$app->request->queryParams;
        $table  = LimeStringHelper::camelize($queryParams['table']);
        $tableModelStr = $this->modelPath.$table;
        $model = new $tableModelStr();
        $dataProvider = $searchModel->search($model,Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Base model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Base model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($table)
    {
        $table  = LimeStringHelper::camelize($table);
        $modelName = $this->modelPath.$table;
        $model = new $modelName();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'table'=>$table]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Base model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $table = Yii::$app->request->queryParams['table'];
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id,'table'=>$table]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Base model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        $table = Yii::$app->request->queryParams['table'];
        return $this->redirect(['index','table'=>$table]);
    }

    /**
     * Finds the Base model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Base the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        $queryParams = Yii::$app->request->queryParams;
        $table  = LimeStringHelper::camelize($queryParams['table']);
        $tableModelStr = $this->modelPath.$table;
        $model = new $tableModelStr();
        if (($model = $model->findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
