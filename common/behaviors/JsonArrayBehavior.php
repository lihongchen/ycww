<?php
namespace common\behaviors;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\AttributeBehavior;
use yii\helpers\Json;

class JsonArrayBehavior extends AttributeBehavior
{
    // 其它代码
    public $attributes = [];
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeValidate',
            ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
        ];
    }

    public function beforeValidate($event)
    {       
        Yii::error($event->name);
        
            Yii::error($event);
        
        // 处理器方法逻辑
        if (!empty($this->attributes)) {
            $attributes = (array) $this->attributes;
            
            foreach ($attributes as $attribute) {
                // ignore attribute names which are not string (e.g. when set by TimestampBehavior::updatedAtAttribute)
                if (is_string($attribute)) {
                    if (empty($this->owner->$attribute)) {
                        continue;
                    }
                    $this->owner->$attribute = Json::encode($this->owner->$attribute);
                }
            }
        }

    }
    public function afterFind($event)
    {
        // 处理器方法逻辑(已经存储为字符串列表页面展示有问题)
        if (!empty($this->attributes)) {
            $attributes = (array) $this->attributes;
            foreach ($attributes as $attribute) {

                // ignore attribute names which are not string (e.g. when set by TimestampBehavior::updatedAtAttribute)
                if (is_string($attribute)) {
                    if (empty($this->owner->$attribute)) {
                        continue;
                    }
                //     $ss = Json::decode($this->owner->$attribute);
                    $str = $this->owner->$attribute;
                // var_dump( json_decode($str,true));
                // die;
                    $this->owner->$attribute = Json::decode($this->owner->$attribute);
                }
            }
        }
    }
}