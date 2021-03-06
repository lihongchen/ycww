<?php

namespace frontend\models;

use Yii;
use common\behaviors\JsonArrayBehavior;
/**
 * This is the model class for table "cus_assess".
 *
 * @property int $id
 * @property string $create_date
 * @property string $update_date
 * @property int $status 0 不可用  1 可用
 * @property string $name 名称
 * @property int $sex 性别
 */
class cusAssess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cus_assess';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
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
            'sex' => '性别',
        ];
    }

 public function qmylRules()
    {
        return   'a:2:{s:4:"name";s:21:"{"db_type":"varchar"}";s:3:"sex";s:68:"{"rules":{"radio":"","refids":"","dictionary_id":1},"db_type":"int"}";}'  ; 
    }
}