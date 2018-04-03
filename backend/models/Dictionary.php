<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "dictionary".
 *
 * @property int $id
 * @property string $create_date
 * @property string $update_date
 * @property int $status 0 不可用  1 可用
 * @property string $name 字典名称
 * @property string $select_value
 * @property string $interface 接口获取数据
 */
class Dictionary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dictionary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
            [['status'], 'integer'],
            [['select_value'], 'string'],
            [['name', 'interface'], 'string', 'max' => 255],
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
            'name' => '字典名称',
            'select_value' => 'Select Value',
            'interface' => '接口获取数据',
        ];
    }
}
