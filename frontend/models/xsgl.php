<?php

namespace frontend\models;

use Yii;
use common\behaviors\JsonArrayBehavior;
/**
 * This is the model class for table "xsgl".
 *
 * @property int $id
 * @property string $create_date
 * @property string $update_date
 * @property int $status 0 不可用  1 可用
 * @property string $name 名称
 * @property string $saletime 销售时间
 * @property int $sex 性别
 */
class xsgl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'xsgl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date', 'saletime'], 'safe'],
            [['status', 'sex'], 'integer'],
            [['name'], 'string', 'max' => 500],
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
            'name' => '名称',
            'saletime' => '销售时间',
            'sex' => '性别',
        ];
    }

 public function qmylRules()
    {
        return   'a:3:{s:4:"name";s:21:"{"db_type":"varchar"}";s:8:"saletime";s:18:"{"db_type":"date"}";s:3:"sex";s:17:"{"db_type":"int"}";}'  ; 
    }
}