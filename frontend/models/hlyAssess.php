<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "hly_assess".
 *
 * @property int $id
 * @property string $create_date
 * @property string $update_date
 * @property int $status 0 不可用  1 可用
 * @property string $xingxiangwaibiao
 * @property string $putonghuashuiping
 * @property string $nanfangcai
 * @property string $beifangcai
 * @property string $mianshi
 * @property string $haixian
 * @property string $weishengxiguan
 * @property string $xinggetedian
 * @property string $aihao
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
            [['status'], 'string', 'max' => 3],
            [['xingxiangwaibiao', 'putonghuashuiping', 'nanfangcai', 'beifangcai', 'mianshi', 'haixian', 'weishengxiguan', 'xinggetedian', 'aihao'], 'string', 'max' => 255],
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
            'xingxiangwaibiao' => 'Xingxiangwaibiao',
            'putonghuashuiping' => 'Putonghuashuiping',
            'nanfangcai' => 'Nanfangcai',
            'beifangcai' => 'Beifangcai',
            'mianshi' => 'Mianshi',
            'haixian' => 'Haixian',
            'weishengxiguan' => 'Weishengxiguan',
            'xinggetedian' => 'Xinggetedian',
            'aihao' => 'Aihao',
        ];
    }
}
