<?php
/**
 * Created by PhpStorm.
 * User:    Joe
 * Project: careerManage
 * Date:    2017/12/19
 * Time:    16:43
 */
namespace common\libraries;

use Yii;
use yii\log\Logger;

class DataHelper
{
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 0;

    /**
     * 多选数据 数组转字符串
     * 将信息转换为以逗号【,】连接的字符串
     * 方便存入数据库
     * @param $data
     * @return mixed
     */
    public static function multiDataToStr($data)
    {
        foreach ($data as $key => $value){
            if(is_array($data[$key])){
                foreach ($value as $k => $v){
                    $data[$key][$k] = is_array($data[$key][$k])?implode(',',$data[$key][$k]):$v;
                }
            }
        }
        return $data;
    }

    /**
     * 多选数据 字符串转数组
     * 将数据库取出的字符串数据,转换为数组，赋值给对应的属性。
     * @param $model
     * @param array $mapArr 需要处理的字段数组。
     * @param string $delimiter 切割分隔符
     * @return mixed
     */
    public static function multiDataToArray($model, $mapArr = [], $delimiter = ''){

        foreach ($mapArr as $key){
            try{
                $model->$key = explode($delimiter,$model->$key);
            }catch (yii\base\UnknownPropertyException $e){
                continue;
            }
        }
        return $model;
    }


    /**
     * 去除首尾空格（包括全角）
     * @param $string
     * @return false|string
     */
    public static function removeSpace($string){
        $string = mb_ereg_replace('^(	|	)+', '', $string);
        $str = mb_ereg_replace('^(　| )+', '', $string);
        $str = mb_ereg_replace('(　| )+$', '', $str);
        $str = mb_ereg_replace('	', "", $str);
        return mb_ereg_replace('　　', "", $str);
    }

    /**
    $date_str 时间
    $ret_type 返回的格式类型
     **/
    public static function dateFormate($date_str,$ret_type){
        return date($ret_type,strtotime($date_str));
    }


    /**
    将 12分49秒  转换为 12*60+49=769 秒
    */
    public static function minuteSecond2Second($str){
        if(strpos($str,'分') && strpos($str,'秒')){
            $str = str_replace('秒', '', $str);
            $strarray = explode('分',$str);
            if(count($strarray)!=2){
                return 0;
            }else{
                return $strarray[0]*60 + $strarray[1];
            }
        }
    }

        /**
    将 12分49秒  转换为 12*60+49=769 秒
    */
    public static function second2minuteSecond($second){
        $minute = intval($second/60);
        $second = intval($second%60);
        return $minute.'分'.$second.'秒'; 
    }

}