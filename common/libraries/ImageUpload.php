<?php
namespace common\libraries;

use Yii;
use common\libraries\imageImpl\UploadInfo;
class ImageUpload {

	/**
	 * 错误信息
	 */
	public $error = '';

	public function upload($field) {	
        $retmess = array();
		$upload_file = $_FILES[$field];
		$realpath = $upload_file['tmp_name'];
		
		$tmp_ext = explode(".", $upload_file['name']);
		$tmp_ext = $tmp_ext[count($tmp_ext) - 1];
		$ext = strtolower($tmp_ext);

		if(!self::upLoadImageCheck($field, $ext)) {
        	$uploadInfo = new UploadInfo();
			$uploadInfo->error = $this->error;
			$uploadInfo->code = 501;
			return $uploadInfo;
		}
		$class = Yii::$app->params['image_zend'];
		$fullclass = "\\common\\libraries\\imageImpl\\".$class;
		$uploadZend = new $fullclass();
		return $uploadZend->upload($realpath, $ext); 		
	}



	/**
	 * 检查上传文件是否正常
	 */
	function upLoadImageCheck($field, $ext = 'jpg', $max_size = 2048*10 ) {

		//上传文件
		$upload_file = $_FILES[$field];
		if ($upload_file['tmp_name'] == "") {
			$this -> log_error_exe('没有发现上传的临时文件');
			return false;
		}

		//对上传文件错误码进行验证
		$error = $this -> fileInputError($upload_file);
		if (!$error) {
			return false;
		}

		//验证是否是合法的上传文件
		if (!is_uploaded_file($upload_file['tmp_name'])) {
			$this -> log_error_exe('上传文件不合法tmp_name');
			return false;
		}

		//验证文件大小
		if ($upload_file['size'] == 0) {
			$this -> log_error_exe('上传文件不合法size0');
			return false;
		}
		if ($upload_file['size'] > $max_size * 1024) {
			$this -> log_error_exe('上传文件不合法size1024');
			return false;
		}

		$allow_type = array('gif', 'jpg', 'jpeg', 'bmp', 'png', 'swf', 'tbi');
		//验证文件格式是否为系统允许
		if (!in_array($ext, $allow_type)) {
			$this -> log_error_exe('上传文件格式不正确');
			return false;
		}

		//检查是否为有效图片
		if (!$image_info = @getimagesize($upload_file['tmp_name'])) {
			$this -> log_error_exe('图片已经损坏');
			return false;
		}
        return true;
	}



	/**
	 * 错误日志处理
	 */
	function log_error_exe($info) {
		$this -> error = $info;
	}

	/**
	 * 获取上传文件的错误信息
	 *
	 * @param string $field 上传文件数组键值
	 * @return string 返回字符串错误信息
	 */
	private function fileInputError($upload_file) {
		switch($upload_file['error']) {
			case 0 :
				//文件上传成功
				return true;
				break;

			case 1 :
				//上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值
				$this -> log_error_exe('上传的文件超过了 php.ini 中 upload_max_filesize 选项限制的值');
				return false;
				break;

			case 2 :
				//上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值
				$this -> log_error_exe('上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值');
				return false;
				break;

			case 3 :
				//文件只有部分被上传
				$this -> log_error_exe('文件只有部分被上传');
				return false;
				break;

			case 4 :
				//没有文件被上传
				$this -> log_error_exe('没有文件被上传');
				return false;
				break;

			case 6 :
				//找不到临时文件夹
				$this -> log_error_exe('找不到临时文件夹');
				return false;
				break;

			case 7 :
				//文件写入失败
				$this -> log_error_exe('文件写入失败');
				return false;
				break;

			default :
				return true;
		}
	}

}
?>