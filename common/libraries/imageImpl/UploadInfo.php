<?php
namespace common\libraries\imageImpl;

use Yii;

class UploadInfo{
	public $error ; 
	public $code = '101'; //101 表示成功   501 表示失败
	public $width;
	public $height;
	public $md5;
} 

?>