<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
/**
 * This is system data dictionary
 */
class DataDict  
{

    public static function getDict($key){

        $db_type = array('int'=>'整数','smallint'=>'短整数','decimal'=>'小数',
                    'varchar'=>'字符串','text'=>'大文本',
                    'date'=>'日期','datetime'=>'日期时间',
                    );
        $rule_group = array('长度'=>'长度','对象'=>'对象','精度'=>'精度',
                    '日期格式'=>'日期格式','收集方式'=>'收集方式',
                    );
        $widget_type = array('textbox'=>'文本框','textarea'=>'富文本框','checkbox'=>'复选框组','select'=>'下拉框','date'=>'日期','datetime'=>'日期时间',
                    );
        $self_use = array(1=>'自用',2=>'公用',);


        $behaviorsPath = Yii::getAlias("@common").'/behaviors';
        $behaviorsFiles = FileHelper::findFiles($behaviorsPath);
        $qmbehaviors = array();
        foreach ($behaviorsFiles as $value) {
            $fileName = basename($value,'.php');
            $qmbehaviors[$fileName] = $fileName ;
        }


        if(empty($key)){
            return [];
        }

        $dictArray = array('status'=>array(1=>'使用',0=>'作废'),
                            'operations'=>array('C'=>'创建','R'=>'查看','U'=>'更新','D'=>'删除'),
                            'db_type'=>$db_type,
                            'qmbehaviors'=>$qmbehaviors,
                            'rule_group'=>$rule_group,
                            'widget_type'=>$widget_type,
                            'self_use'=>$self_use,

                          );
        return $dictArray[$key];
    } 
}
