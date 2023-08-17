<?php
namespace frontend\controllers;
use yii\rest\ActiveController;
use common\models\Profile;



class UrlController extends ActiveController
{
    public $modelClass=Profile::class;
}