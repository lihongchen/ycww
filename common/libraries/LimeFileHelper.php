<?php

namespace common\libraries;

use Yii;
use yii\helpers\FileHelper;
class LimeFileHelper  extends FileHelper
{
    /**
     * 保存文件
     * 
     * @param string $fileName 文件名（含相对路径）
     * @param string $text 文件内容
     * @return boolean 
     */
    public function saveFile($fileName, $text) {
        if (!$fileName || !$text)
            return false;
        $fileName = $this->normalizePath($fileName);
        if ($this->createDirectory(dirname($fileName))) {
            if ($fp = fopen($fileName, "w")) {
                if (@fwrite($fp, $text)) {
                    fclose($fp);
                    return true;
                } else {
                    fclose($fp);
                    return false;
                } 
            } 
        } 
        return false;
    } 
}