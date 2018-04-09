<?php

namespace common\libraries;

use Yii;
class LimeCreateNO  
{
    //生成护理员编号
    public static function createHlyNo(){
        
        $year = Date("y");
        $reg = "hly_no".$year;
        $cmd = Yii::$app->qmcus->createCommand("call max_id(:reg,@s)");
        $cmd->bindParam(':reg',$reg,\PDO::PARAM_STR,10);
        $cmd->execute();
        $s = Yii::$app->qmcus->createCommand("select @s");
        $ret = $s->queryOne();
        if(!empty($ret)&& !empty($ret['@s'])){
            $hly_no =  $year.str_pad($ret['@s'],6, "0", STR_PAD_LEFT);
            $hly_no = $hly_no.rand(11,99);
        }else{
            throw new Exception("获取护理员编号错误");
        }
        return $hly_no;
    }
}