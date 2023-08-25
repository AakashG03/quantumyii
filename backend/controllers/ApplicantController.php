<?php

namespace backend\controllers;

use yii\web\BadRequestHttpException;
use common\models\Applicant;
use backend\models\QuantumLogin;
use backend\models\QuantumPasswordResetRequest;
use backend\models\QuantumResetPassword;
use yii\rest\ActiveController;
use Yii;
use yii\db\Query;

class ApplicantController extends ActiveController
{

    public $modelClass = Applicant::class;

    public function actionOptions()
    {
        $header = header('Access-Control-Allow-Origin: *');
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // remove authentication filter
        $auth = $behaviors['authenticator'];
        unset($behaviors['authenticator']);

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::class,
        ];

        // re-add authentication filter
        $behaviors['authenticator'] = $auth;
        // avoid authentication on CORS-pre-flight requests (HTTP OPTIONS method)
        $behaviors['authenticator']['except'] = ['options'];

        return $behaviors;
    }
    public function actionPreview()
    {
        $id = Yii::$app->request->get('id');
        if (!$id) {
            $profiles = Applicant::find()->asArray()->all();
            return ['data'=>$profiles];
        } else {
            $profiles = Applicant::find()->where(['id' => $id])->asArray()->one();
            return ['data'=>$profiles];
        }
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
        $login = new QuantumLogin();
        $data = $login->findByEmail();
        if($data){
            return ["data"=>$data];
        }else{
            return ["data"=>"No Email found"];
        }
    }
    public function actionCheckauth(){
        $request = Yii::$app->request;
        $auth_key = $request->getBodyParam('auth_key');
        $query = (new Query())
        ->select('first_name')
        ->from('applicant')
        ->where(['auth_key'=>$auth_key])
        ->one();
        return ["data"=>$query];
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
        if ($model === null)
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
