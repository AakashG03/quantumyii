<?php

namespace backend\models;

use yii\base\Model;
use common\models\Applicant;

class QuantumPasswordResetRequest extends Model
{
    public $email;
    public function rules()
    {
        return [
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'exist',
                'targetClass' => '\common\models\Applicant',
                'message' => 'There is no user with this email address.'
            ],
        ];
    }
    public function sendEmail()
    {
        //     /* @var $user User */
        //     $user = User::findOne([
        //         'status' => User::STATUS_ACTIVE,
        //         'email' => $this->email,
        //     ]);

        //     if (!$user) {
        //         return false;
        //     }

        //     if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
        //         $user->generatePasswordResetToken();
        //         if (!$user->save()) {
        //             return false;
        //         }
        //     }

        //     return Yii::$app
        //         ->mailer
        //         ->compose(
        //             ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'],
        //             ['user' => $user]
        //         )
        //         ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
        //         ->setTo($this->email)
        //         ->setSubject('Password reset for ' . Yii::$app->name)
        //         ->send();



        // ABOVE IS THE ORIGINAL CODE WHICH WILL BE USED TO SEND EMAIL 
        // BELOW CODE WILL JUST OUTPUT THE TOKEN REQUIRED
        $applicant = Applicant::findOne(['email' => $this->email]);
        if (!$applicant) {
            return false;
        }
        if (!Applicant::isPasswordResetTokenValid($applicant->password_reset_token)) {
            $applicant->password_reset_token = $applicant->generatePasswordResetToken();
            if (!$applicant->save()) {
                return false;
            }
        } else {
            echo "Token already set \n";
            return true;
        }
    }
}
