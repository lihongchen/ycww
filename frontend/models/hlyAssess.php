<?php

namespace frontend\models;

use Yii;
use common\behaviors\JsonArrayBehavior;
/**
 * This is the model class for table "hly_assess".
 *
 * @property int $id
 * @property string $create_date
 * @property string $update_date
 * @property int $status 0 不可用  1 可用
 * @property string $xingxiangwaibiao 形象外表
 * @property string $putonghuashuiping 普通话水平
 * @property string $nanfangcai 膳食水平南方菜
 * @property string $beifangcai 膳食水平北方菜
 * @property string $mianshi 膳食水平面食
 * @property string $haixian 膳食水平海鲜
 * @property string $weishengxiguan 卫生习惯
 * @property string $xinggetedian 性格特点
 * @property string $aihao 爱好
 */
class hlyAssess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'hly_assess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
            [['status'], 'integer'],
            [['xingxiangwaibiao', 'putonghuashuiping', 'nanfangcai', 'beifangcai', 'mianshi', 'haixian', 'weishengxiguan', 'xinggetedian', 'aihao'], 'string', 'max' => 500],
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
            'xingxiangwaibiao' => '形象外表',
            'putonghuashuiping' => '普通话水平',
            'nanfangcai' => '膳食水平南方菜',
            'beifangcai' => '膳食水平北方菜',
            'mianshi' => '膳食水平面食',
            'haixian' => '膳食水平海鲜',
            'weishengxiguan' => '卫生习惯',
            'xinggetedian' => '性格特点',
            'aihao' => '爱好',
        ];
    }

 public function qmylRules()
    {
        return   'a:9:{s:16:"xingxiangwaibiao";s:75:"{"rules":{"checkbox":"","refids":"","dictionary_id":2},"db_type":"varchar"}";s:17:"putonghuashuiping";s:72:"{"rules":{"radio":"","refids":"","dictionary_id":3},"db_type":"varchar"}";s:10:"nanfangcai";s:75:"{"rules":{"checkbox":"","refids":"","dictionary_id":5},"db_type":"varchar"}";s:10:"beifangcai";s:75:"{"rules":{"checkbox":"","refids":"","dictionary_id":5},"db_type":"varchar"}";s:7:"mianshi";s:75:"{"rules":{"checkbox":"","refids":"","dictionary_id":7},"db_type":"varchar"}";s:7:"haixian";s:75:"{"rules":{"checkbox":"","refids":"","dictionary_id":8},"db_type":"varchar"}";s:14:"weishengxiguan";s:75:"{"rules":{"checkbox":"","refids":"","dictionary_id":9},"db_type":"varchar"}";s:12:"xinggetedian";s:76:"{"rules":{"checkbox":"","refids":"","dictionary_id":10},"db_type":"varchar"}";s:5:"aihao";s:76:"{"rules":{"checkbox":"","refids":"","dictionary_id":11},"db_type":"varchar"}";}'  ; 
    }
 public function behaviors()
    {
        return array_merge(parent::behaviors(), [  
            [
                'class'   => JsonArrayBehavior::className(),
                'attributes' => ["xingxiangwaibiao","nanfangcai","beifangcai","mianshi","haixian","weishengxiguan","xinggetedian","aihao"],
            ],

         ]);
    }
}