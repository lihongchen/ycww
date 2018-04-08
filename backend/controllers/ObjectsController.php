<?php

namespace backend\controllers;

use Yii;
use backend\models\Objects;
use backend\models\ObjectFields;
use backend\models\ObjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Migration;
use backend\models\Rules;
use yii\helpers\Json;
/**
 * ObjectsController implements the CRUD actions for Objects model.
 */
class ObjectsController extends Controller
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
     * Lists all Objects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ObjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Objects model.
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
     * Creates a new Objects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Objects();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Objects model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Objects model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actionDb($id){
        $objects = Objects::find()->select(['id','name','en_name'])->where(['status'=>1])->orderBy('order')->asArray()->all();

        $rules = $this->buildRules();
        foreach ($objects as $key => $value) {
            $objectFields = ObjectFields::find()->select(['name','en_name','rules','db_type'])->where(['status'=>1,'object_id'=>$value['id']])->asArray()->all();
            $this->createTable($value['en_name'],$objectFields,$rules);
        }

    }

    public function buildRules(){
        $ruls = Rules::find()->select(['id','name','en_name','refids','rule_value','widget_type'])->where(['status'=>1])->all();
        $idRuls = array();
        foreach ($ruls as $key => $value) {
            $idRuls[$value['id']] = array($value['en_name']=>$value['rule_value'],'refids'=>$value['refids'] );
        }
        foreach ($idRuls as $key => $value) {
            if(!empty($value['refids'])){
                $refidsArray = ($value['refids']);          
                $deptRules = $this->recursiveRuls($idRuls,$refidsArray);
                unset($deptRules['refids']);
                $idRuls[$key] =  array_merge($idRuls[$key],$deptRules);
            }
        }
        return $idRuls;
    }


    public function recursiveRuls($idRuls,$ids){
        $retRuls = array();
        foreach ($ids as $key => $value) {
            $tmp = $idRuls[$value];
            unset($tmp['refids']);
            $retRuls = array_merge($retRuls,$tmp);
            if (!empty($idRuls[$value]['refids'])) {
                $refidsArray = ($idRuls[$value]['refids']);
                $retRuls =  array_merge($retRuls, $this->recursiveRuls($idRuls,$idRuls[$value]['refids']));
            }
        }
        return $retRuls;
    }


    public function createTable($table_name,$fields,$rules){
        $mir = new Migration();  
        $sch = new \yii\db\mysql\Schema;
        $msyqlRules = array('maxLength','minLength');
        $mysqlDefault = array('varchar'=>255,'smallint'=>6,'int'=>11);
        $tmpFields = array();
        foreach ($fields as $key => $value) {
            if((isset($sch->typeMap[$value['db_type']]))){
                $tmpFields[$value['en_name']] =  $sch->typeMap[$value['db_type']] ;
            }
            
        }

        $baseFields = [  
            'id' => 'pk',  
            'create_date' => $sch::TYPE_DATETIME . '  DEFAULT CURRENT_TIMESTAMP ',  
            'update_date' => $sch::TYPE_DATETIME . '  DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ',  
            'status' => $sch::TYPE_TINYINT . '   DEFAULT \'1\' COMMENT \'0 不可用  1 可用\' ', 
            ];

        $mir->createTable($table_name, array_merge($baseFields,$tmpFields)); 
    }


    /**
     * Finds the Objects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Objects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Objects::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
