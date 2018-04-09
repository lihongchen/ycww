<?php

namespace common\libraries;

use Yii;
class DateHelper   
{
     public static function currentDate(){
        return date("Y-m-d",time());
     }

	/**
	$date_str 时间
	$ret_type 返回的格式类型
	**/
	public static function dateFormate($date_str,$ret_type){
		return date($ret_type,strtotime($date_str));
     }
}