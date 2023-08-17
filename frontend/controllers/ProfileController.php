<?php

namespace frontend\controllers;

use Yii;
use common\models\Profile;

use \yii\web\Controller;
use yii\base\NotSupportedException;



class ProfileController extends Controller
{
    public $Profilemodel = Profile::class;

    public function actionCreate()
    {
        $model = new Profile();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['home']);
        }
        
        return $this->render('create', ['model' => $model]);
    }

    public function actionIndex()
    {
        // $profiles = User::findByUsername('testUser');
        // return $this->render('index',['model'=>$profiles]);
        
        $profiles = Profile::find()->all();
        // echo $model;
        return $this->render('home', ['model' => $profiles]);
    }
    public function actionView()
    {
        $id = $_GET['id'];
        $profiles = Profile::find()->where(['user_id'=>$id])->all();
        return $this->render('view', ['model' => $profiles]);
    }
    public function actionEdit($id)   
    {   
        $model = Profile::find()->where(['user_id' => $id])->one();   
   
        // $id not found in database   
        if($model === null)   
            throw new NotSupportedException('The requested page does not exist.');   
           
        // update record   
        if($model->load(Yii::$app->request->post()) && $model->save()){   
            return $this->redirect(['home']);   
        }   
           
        return $this->render('update', ['model' => $model]);   
    }
    public function actionDelete($id)   
    {   
        $model = Profile::findOne($id);   
          
       // $id not found in database   
       if($model === null)   
           throw new NotSupportedException('The requested page does not exist.');   
              
       // delete record   
       $model->delete();   
          
       return $this->redirect(['home']);   
    }         
}
