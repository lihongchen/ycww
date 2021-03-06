<?php

namespace backend\models;

use Yii;
use common\behaviors\JsonArrayBehavior;

/**
 * This is the model class for table "objects".
 *
 * @property int $id
 * @property string $create_date
 * @property string $update_date
 * @property int $status 0 不可用  1 可用
 * @property string $name 对象名称
 * @property string $operations 操作内容（crud）["c","r","u","d"]
 * @property string $list_show_fields list 页面显示字段，空为显示所有
 * @property int $parent_id 父对象id 
 * @property int $order 排序
 * @property string $en_name 对象英文标识符
 */
class Objects extends \yii\db\ActiveRecord
{



    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class'   => JsonArrayBehavior::className(),
                'attributes' => 'operations',
            ],
        ]);
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'objects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
            [['status', 'parent_id','order'], 'integer'],
            [['name'], 'required'],
            [['name', 'operations', 'list_show_fields', 'en_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'create_date' => 'Create Date',
            'update_date' => 'Update Date',
            'status' => '0 不可用  1 可用',
            'name' => '对象名称',
            'operations' => '操作内容（crud）[\"c\",\"r\",\"u\",\"d\"]',
            'list_show_fields' => 'list 页面显示字段，空为显示所有',
            'parent_id' => '父对象', 
            'order' => '排序',
            'en_name' => '对象英文标识符', 
        ];
    }

    public function getParentCode($id){
        if(empty($id)){
            $id=-1;
        }
        $objs = Objects::find()->select("id,name")->where(['!=', 'id', $id])->all();
        $retarray = array();
        foreach ($objs as $key => $value) {
            $retarray[$value['id']] = $value['name'] ; 
        }
        return $retarray;
    }

    /**
    * @return \yii\db\ActiveQuery
    */
   public function getObjectFields()
   {
       return $this->hasMany(ObjectFields::className(), ['object_id' => 'id']);
   }
}
