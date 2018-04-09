<?php

namespace common\libraries;

use Yii;
use yii\helpers\Html;
class LimeHtmlHelper  extends Html
{

    public static function dorpDownBtn($itmes, $config = [])
    {
        /* 定义初始值 */
        $content = null;
        $btnConfig = ['class' => "glyphicon glyphicon-cog", "id" => "dropdownMenu1", "data-toggle" => "dropdown", "aria-haspopup" => "true", "aria-expanded" => "true"];
        $spanConfig = ['class' => "caret"];
        $divConfig = ['class' => "dropdown pull-right"];
        $ulConfig = ['class' => "dropdown-menu", "aria-labelledby" => "dropdownMenu1"];
        $btnTitle = '';
        /* 初始值定义结束 */
        is_array($config) && count($config) > 0 ? extract($config) : true;
        $span = Html::tag('span', $content, $spanConfig);
        $btn = Html::button($btnTitle . $span, $btnConfig);
    	$lis = "";
    	foreach ($itmes as $key => $value) {
    		if(empty($value['options'])){
				$a = Html::a($value['name'],$value['url']) ;
    		}else{
    			$a = Html::a($value['name'],$value['url'],$value['options']) ;
    		}
             
    		 $lis .= Html::tag('li',$a );
    	}

        $ul = Html::tag('ul', $lis, $ulConfig);
        return Html::tag('div', $btn . $ul, $divConfig);
    }
}