<?php
namespace common\models;

use Yii;
use backend\models\Objects;
/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */
class Menu 
{
    public static function menus(){
        $objects = Objects::find()->select(['name','en_name'])->where(['status'=>1])->orderBy('order')->asArray()->all();
        return $objects;
    }
}
