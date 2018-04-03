<?php

namespace backend\models;

use Yii;
use common\behaviors\JsonArrayBehavior;
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
 * @property string $group 分组
 */
class Rules extends \yii\db\ActiveRecord
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            [
                'class'   => JsonArrayBehavior::className(),
                'attributes' => 'refids',
            ],
        ]);
    }

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
            [['name', 'refids', 'en_name', 'rule_value', 'rule_group'], 'string', 'max' => 255],
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
            'rule_group' => '分组',
        ];
    }

    public function getRules($id){
        if(empty($id)){
            $id=-1;
        }
        $objs = Rules::find()->select("id,name,rule_group")->where(['!=', 'id', $id])->orderBy('convert(rule_group using gbk) asc') ->all();
        $retarray = array();
        foreach ($objs as $key => $value) {
            $retarray[$value['id']] = $value['rule_group'].":".$value['name'] ; 
        }
        return $retarray;
    }
}
