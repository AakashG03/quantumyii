<?php

namespace backend\models;

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
    public function findByEmail()
    {
        $model = new Applicant();
        $request = Yii::$app->request;
        $this->email = $request->getBodyParam('email');
        $row = Applicant::find()->where(['email' => $this->email])->asArray()->one();
        if (!is_null($row)) {
            if ($model->validatePassword($request->getBodyParam('password'), $row['password']) && $this->login()) {
                return $row;
            }
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
        $data = $model->findByUsername($this->email);
        return $data;
        // echo json_encode($data);
    }
}
