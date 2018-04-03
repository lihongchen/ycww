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
                          );
        return $dictArray[$key];
    } 
}
