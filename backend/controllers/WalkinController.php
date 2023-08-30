<?php

namespace backend\controllers;

use common\models\JobRoles;
use common\models\Hallticket;
use yii\db\Query;
use yii\rest\ActiveController;
use Yii;

class WalkinController extends ActiveController
{
    public $modelClass = JobRoles::class;
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
    public function actionView()
    {
        $model = JobRoles::find()->asArray()->all();
        return ['data' => $model];
    }

    public function actionJoblist()
    {
        $data = [];
        $count1 = (new Query())->select('walkinjoblist.job_id')->from('walkinjoblist')->count();
        $i = 1;
        while ($i <= $count1) {
            $job_role = [];
            $model1 = (new Query())->select('walkinjoblist.id,walkinjoblist.job_title,walkinjoblist.expire,walkinjoblist.start_date,walkinjoblist.end_date,
            walkinjoblist.location,walkinjoblist.internship')
                ->from('walkinjoblist')
                ->where(['walkinjoblist.id' => $i])
                ->one();
            $model2 = (new Query())->select('roles.role_name')
                ->from('roles')
                ->join('INNER JOIN', 'job_roles', 'job_roles.role_id=roles.id')
                ->where(['job_roles.job_id' => $i])
                ->all();
            $count2 = count($model2);
            $role_array = [];
            $j = 0;
            while ($j < $count2) {
                array_push($role_array, $model2[$j]['role_name']);
                $j++;
            }
            $job_role = ["job_roles" => $role_array];
            array_push($data, array_merge($model1, $job_role));
            $i++;
        }
        return ['data' => $data];
    }

    public function actionJobdetails($id)
    {
        $model1 = (new Query())->select('walkinjoblist.id,walkinjoblist.job_title,walkinjoblist.start_date,walkinjoblist.end_date,
            walkinjoblist.location,walkinjoblist.internship,walkinjoblist.general_instructions,walkinjoblist.exam_instructions,
            walkinjoblist.minimum_sys_req,walkinjoblist.process')
            ->from('walkinjoblist')
            ->where(['walkinjoblist.id' => $id])
            ->one();
        $model2 = (new Query())->select('roles.id,roles.role_name,roles.gross_package,roles.role_description,roles.requirements')
            ->from('roles')
            ->join('INNER JOIN', 'job_roles', 'job_roles.role_id=roles.id')
            ->where(['job_roles.job_id' => $id])
            ->all();
        $count2 = count($model2);
        $role_array = [];
        $j = 0;
        while ($j < $count2) {
            array_push($role_array, $model2[$j]);
            $j++;
        }
        $job_role = ["job_roles" => $role_array];
        // echo json_encode(array_merge($model1, $job_role), JSON_PRETTY_PRINT);
        return ['data' => array_merge($model1, $job_role)];
    }

    public function actionApplyjob()
    {
        $header = header('Access-Control-Allow-Origin: *');
        $model = new Hallticket();
        if ($model->load(Yii::$app->getRequest()->post(), '') && $model->save()) {
            return ['data' => 'Hallticket Created'];
            // echo "Hallticket Created";
        } else {
            // return ['data' => 'Error'];
            print_r($model->getAttributes());
            print_r($model->getErrors());
            exit;
        }
    }

    public function actionViewhallticket($id)
    {
        $hallticket = Hallticket::find()->where(['id' => $id])->asArray()->one();
        return ['data' => $hallticket];
        // echo json_encode($hallticket, JSON_PRETTY_PRINT);
    }
}
