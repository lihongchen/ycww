<?php
namespace common\libraries\imageImpl;

use Yii;
use common\libraries\LimeCurl;
use common\libraries\imageImpl\UploadInfo;

 
class zimg {


	public function upload($realpath, $ext) {
		$imagesize = getimagesize($realpath);
        $uploadInfo = new UploadInfo();
		$uploadInfo->width = $imagesize['0'];
		$uploadInfo->height = $imagesize['1'];

		// 上传图片到zimg图片存储服务
		$zimg_upload_url = Yii::$app->params['image_upload_url'];
		
		$post_data = file_get_contents($realpath);
		$limeCurl = new LimeCurl();
		$headers = array();
		$headers[] = 'Content-Type:' . $ext;
		$json = $limeCurl->curl_post_file($zimg_upload_url,$post_data,$headers);
		$uploadInfo->md5 = $json['info']['md5'];
		$uploadInfo->code = 101;
		//TODO 出错处理
		return $uploadInfo;
	}

	public function uploadData($data,$ext) {
		// 上传图片到zimg图片存储服务
		$zimg_upload_url = Yii::$app->params['image_upload_url'];
		$post_data = $data;
		$limeCurl = new LimeCurl();
		$headers = array();
		$headers[] = 'Content-Type:' . $ext;
		$json = $limeCurl->curl_post_file($zimg_upload_url,$post_data,$headers);
		$uploadInfo  = $json['info']['md5'];
		//TODO 出错处理
		return $uploadInfo;
	}


}
?>