<?php

namespace common\libraries;

use Yii;
class LimeCurl  
{
    public function curl_post($url, $post_data, $headers) {
        $ch = curl_init();
        //初始化一个cURL会话
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置访问 header
        if ($headers != null){
            $headers = array_merge(array('Content-Type: application/json'),$headers);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        // post的变量
        $json_data = json_encode($post_data);
        //  $json_data = $post_data;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        $output = curl_exec($ch);
        // Check for errors and display the error message
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}\n";
        }

        curl_close($ch);
        //打印获得的数据
        if(!is_array($output)){
            $json_ret = json_decode($output, TRUE);
        return ($json_ret); 
        }else{
            return $output;
        }

    }



    public function curl_post_file($url,$post_data,$headers){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            $info = curl_exec($ch);
            curl_close($ch);
            $json = json_decode($info, true);
            return $json;
    }


    public function curl_post_html($url, $post_data, $headers) {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        curl_close($ch);

        //打印获得的数据
        return ($output);




        }


    public function curl_get($url) {

        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        //打印获得的数据
        $json_ret = json_decode($output, TRUE);
        return ($json_ret);
    }

        //curl file上传文件 post_data必须为数组格式
        //php5.5以前：'pic'=>'@'.realpath($path).";type=".$type.";filename=".$filename
        //php5.5及以后：curlfile curl_file_create
    public function curl_file($url, $post_data, $headers) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);

        //设置访问 header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        $output = curl_exec($ch);
        // Check for errors and display the error message
        if ($errno = curl_errno($ch)) {
            $error_message = curl_strerror($errno);
            echo "cURL error ({$errno}):\n {$error_message}\n";
        }
        curl_close($ch);
        //打印获得的数据
        $json_ret = json_decode($output, TRUE);
        return ($json_ret);
    }

    public function getDirAllFiles($path) {
        $hostdir = realpath($path);
        //获取本文件目录的文件夹地址
        $filesNames = scandir($hostdir);
        $allFiles = array();
        //获取也就是扫描文件夹内的文件及文件夹名存入数组 $filesnames
        foreach ($filesNames as $name) {
            if (!is_file($hostdir . '/' . $name) || pathinfo($name, PATHINFO_EXTENSION) != "json")
                continue;
            $allFiles[] = $name;
        }
        return $allFiles;
    }

    public function getDirAllDir($path) {
        $hostdir = realpath($path);
        //获取本文件目录的文件夹地址
        $filesNames = scandir($hostdir);
        $allDirs = array();
        //获取也就是扫描文件夹内的文件及文件夹名存入数组 $filesnames
        foreach ($filesNames as $name) {
            if (!is_dir($hostdir . '/' . $name))
                continue;
            $allDirs[] = $name;
        }
        return $allDirs;
    }


    public function changeEncode($str){
        return iconv("UTF-8", "GBK//TRANSLIT",$str);
    }
}