<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cus".
 *
 * @property int $id
 * @property string $create_date
 * @property string $update_date
 * @property int $status 0 不可用  1 可用
 * @property int $name
 * @property string $age
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
            [['name'], 'integer'],
            [['status'], 'string', 'max' => 3],
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
            'status' => 'Status',
            'name' => 'Name',
            'age' => 'Age',
        ];
    }
}
