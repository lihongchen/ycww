<?php
namespace common\models;

use Yii;
use backend\models\Dictionary;
use yii\helpers\Json;

class QmylWidgets 
{
    public  function createForm($form,$model){
        $qmylRules = unserialize($model->qmylRules());

        $fields = $model->attributes();
        $fieldHtmls = "";
        $excludeFields = array('id','create_date','update_date','status');
        foreach ($fields as $field) {
            if(in_array($field, $excludeFields)){
                continue;
            }
            $rule = [];
            if(array_key_exists($field,  $qmylRules)){
                $rule = $qmylRules[$field];
                $rule = Json::decode($rule);
            }
            $fieldHtmls .= $this->createWidgets($form,$model,$field,$rule);
        }
        return $fieldHtmls;
    }

    public  function createWidgets($form,$model,$fieldName,$rule){
        $keys = [];
        if(!empty($rule['rules'])){
            $keys = array_keys($rule['rules']);
            $dict = $this->dictionary($rule['rules']);
        }
        $dataType = $rule['db_type'];
        $str = '';
        if(in_array('checkbox', $keys)){
            return $form->field($model, $fieldName)->checkboxList($dict);
        }else if(in_array('radio',$keys)){
            return  $form->field($model, $fieldName)->radioList($dict);
        }else{
            if($dataType == 'date'){
                return  $form->field($model, $fieldName)->textInput(['type'=>'date']); 
           }else{
                return  $form->field($model, $fieldName)->textInput();
           }
            
        }
    }    
    public function dictionary($rule){
        $dicts = Dictionary::getDict();
        $dictId = $rule['dictionary_id'];
        if(empty($dictId)){
            return [];
        }else{
            return $dicts[$dictId];
        }
        
    }

    public static function createIndexColumns($model){
        $behaviors = $model->behaviors();
        $atrs = $model->attributes();
        $attrsJsonArrayBehavior = array();
        if(!empty($behaviors)){
            foreach ($behaviors as $key => $value) {
                $class =  $value['class'];
                if($class =='common\behaviors\JsonArrayBehavior'){
                    $attrsJsonArrayBehavior  = $value['attributes'];
                }
            }
            
        }
        if(!empty($attrsJsonArrayBehavior)){
            foreach ($atrs as $key=>$valueaa) {
                if(in_array($valueaa, $attrsJsonArrayBehavior)){
                    $atrs[$key]  = ['attribute' =>$valueaa ,'value'=>function($model)use($valueaa){
                        return Json::encode($model->$valueaa);
                    }];
                }
            }
        }   
        return  $atrs;   
    }
}
