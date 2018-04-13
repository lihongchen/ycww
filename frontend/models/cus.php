<?php

namespace frontend\models;

use Yii;
use common\behaviors\JsonArrayBehavior;
/**
 * This is the model class for table "cus".
 *
 * @property int $id
 * @property string $create_date
 * @property string $update_date
 * @property int $status 0 不可用  1 可用
 * @property int $name 名称
 * @property string $age 年龄
 */
class cus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cus';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date', 'age'], 'safe'],
            [['status', 'name'], 'integer'],
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
            'age' => '年龄',
        ];
    }

 public function qmylRules()
    {
        return   'a:2:{s:4:"name";s:17:"{"db_type":"int"}";s:3:"age";s:18:"{"db_type":"date"}";}'  ; 
    }
}