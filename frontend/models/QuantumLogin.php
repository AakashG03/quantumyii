<?php

namespace frontend\models;

use common\models\Applicant;
use Yii;
use yii\base\Model;

class QuantumLogin extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    public function rules()
    {
        return [
            ['email', 'required'],
            ['email', 'setEmail'],
            ['password', 'required'],
            ['rememberMe', 'boolean'],
        ];
    }
    public function findByEmail($email)
    {
        $model = new Applicant();
        $request = Yii::$app->request;
        $this->rememberMe = $request->getBodyParam('remember_me');
        $this->email = $request->getBodyParam('email');
        $row = Applicant::find()->where(['email' => $email])->one();
        if (!is_null($row)) {
            if ($model->validatePassword($request->getBodyParam('password'), $row['password']) && $this->login()) {
                return Yii::$app->user->identity;
            } else {
                return json_encode(["creds" => "invalid or not logged in"], JSON_PRETTY_PRINT);
            }
        } else {
            return json_encode(["creds" => "invalid"], JSON_PRETTY_PRINT);
        }
    }
    public function login()
    {
        if (Yii::$app->user->login($this->getEmail())) {
            return 1;
        } else {
            return 0;
        }
    }
    protected function getEmail()
    {
        $model = new Applicant();
        $this->email = $model->findByUsername($this->email);
        return $this->email;
    }
}
