<?php

namespace frontend\controllers;

use yii\web\BadRequestHttpException;
use common\models\Applicant;
use frontend\models\QuantumLogin;
use frontend\models\QuantumPasswordResetRequest;
use frontend\models\QuantumResetPassword;
use yii\rest\ActiveController;
use Yii;

class ApplicantController extends ActiveController
{
    public $modelClass = Applicant::class;
    public function actionPreview()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            $profiles = Applicant::find()->asArray()->all();
            echo json_encode($profiles, JSON_PRETTY_PRINT);
        } else {
            $profiles = Applicant::find()->where(['id' => $id])->asArray()->one();
            echo json_encode($profiles, JSON_PRETTY_PRINT);
        }
        // echo json_encode(Yii::$app->user->identity,JSON_PRETTY_PRINT);
    }
    public function actionAdd()
    {
        $model = new Applicant();
        $request = Yii::$app->request;
        $password = $model->setHashpassword($request->getBodyParam('password'));
        $auth_key = $model->generateAuthKey();
        if ($model->load(Yii::$app->getRequest()->post(), '')) {
            $model->password = $password;
            $model->auth_key = $auth_key;
            if ($model->save()) {
                echo "Model Saved";
            } else {
                echo "MODEL NOT SAVED \n";
                print_r($model->getAttributes());
                print_r($model->getErrors());
                exit;
            }
        }
    }
    public function actionLogin()
    {
        $request = Yii::$app->request;
        $email = $request->getBodyParam('email');
        $login = new QuantumLogin();
        $data = $login->findByEmail($email);
        echo print_r($data);
    }
    public function actionLogout()
    {
        if (Yii::$app->user->logout()) {
            echo "USER LOGGED OUT";
        }
    }
    public function actionRequestpasswordreset()
    {
        $model = new QuantumPasswordResetRequest();
        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            echo "inside";
            if ($model->sendEmail()) {
                $applicant = Applicant::findOne(['email' => Yii::$app->request->getBodyParam('email')]);
                print_r(Applicant::findOne(['email', $applicant]));
                return;
            }
            echo "Failed";
        }
    }
    public function actionResetpassword()
    {
        $request = Yii::$app->request;
        $token = $request->getBodyParam('password_reset_token');
        $model = new QuantumResetPassword($token);



        if ($model->load(Yii::$app->request->post(), '') && $model->validate()) {
            echo "validated";
            // return $this->goHome();
            if ($model->resetPassword($request->getBodyParam('password'))) {
                echo "Password Reset";
            }
        }

        // return $this->render('resetPassword', [
        //     'model' => $model,
        // ]);
    }
    public function actionUpdateapplicant($id)
    {
        $model = Applicant::find()->where(['id' => $id])->one();  
        if($model === null)   
        throw new BadRequestHttpException('The requested page does not exist.');   
        if ($model->load(Yii::$app->getRequest()->post(), '')) {
            if ($model->save()) {
                echo "Changes Saved";
            } else {
                echo "Changes NOT SAVED \n";
                print_r($model->getAttributes());
                print_r($model->getErrors());
                exit;
            }

        }
    }
}
