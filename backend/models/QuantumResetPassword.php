<?php

namespace backend\models;

use yii\base\InvalidArgumentException;
use yii\base\Model;
use common\models\Applicant;


class QuantumResetPassword extends Model
{
    public $_user;
    public $password;
    public function rules()
    {
        return [
            ['password', 'required']
        ];
    }
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidArgumentException('Password reset token cannot be blank.');
        }
        $this->_user = Applicant::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidArgumentException('Wrong password reset token.');
        }
        parent::__construct($config);
    }
    public function resetPassword($password)
    {
        $user = $this->_user;
        $user['password']=$user->setPassword($password);
        $user->removePasswordResetToken();
        $user['auth_key']=$user->generateAuthKey();

        return $user->save(false);
    }
}
