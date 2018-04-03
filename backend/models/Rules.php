<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "rules".
 *
 * @property int $id
 * @property string $create_date
 * @property string $update_date
 * @property int $status 0 不可用  1 可用
 * @property string $name 规则名称
 * @property string $refids 引用规则
 * @property string $en_name 规则英文名称
 * @property string $rule_value 限制值
 */
class Rules extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rules';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
            [['status'], 'integer'],
            [['name', 'refids', 'en_name', 'rule_value'], 'string', 'max' => 255],
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
            'name' => '规则名称',
            'refids' => '引用规则',
            'en_name' => '规则英文名称',
            'rule_value' => '限制值',
        ];
    }
}
