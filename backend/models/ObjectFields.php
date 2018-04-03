<?php

namespace backend\models;

use Yii;
use common\behaviors\JsonArrayBehavior;
/**
 * This is the model class for table "object_fields".
 *
 * @property int $id
 * @property string $create_date
 * @property string $update_date
 * @property int $status 0 不可用  1 可用
 * @property string $en_name 英文名称
 * @property string $name 字段名称
 * @property string $db_type 数据库类型
 * @property string $rules 规则
 * @property int $object_id 对象id
 * @property string $behaviors 行为
 *
 * @property Objects $object
 */
class ObjectFields extends \yii\db\ActiveRecord
{
    // public function behaviors()
    // {
    //     return array_merge(parent::behaviors(), [
    //         [
    //             'class'   => JsonArrayBehavior::className(),
    //             'attributes' => 'qmbehaviors',
    //         ],
    //     ]);
    // }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'object_fields';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_date', 'update_date'], 'safe'],
            [['status', 'object_id'], 'integer'],
            [['en_name', 'name'], 'required'],
            [['rules'], 'string'],
            [['en_name', 'name', 'db_type', 'qmbehaviors'], 'string', 'max' => 255],
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => Objects::className(), 'targetAttribute' => ['object_id' => 'id']],
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
            'en_name' => '英文名称',
            'name' => '字段名称',
            'db_type' => '数据库类型',
            'rules' => '规则',
            'object_id' => '对象id',
            'qmbehaviors' => '行为',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne(Objects::className(), ['id' => 'object_id']);
    }
}
