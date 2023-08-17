<?php

/** @var yii\web\View $this */

use yii\helpers\Html;
$this->title = 'MyPage';
$nameUser = Yii::$app->user->identity->id;
?>
<style>   
table th,td{   
    padding: 10px;   
}   
</style> 
<div >


   
</div>  
   
<?= Html::a('Create', ['profile/create'], ['class' => 'btn btn-success']); ?>   
<h1><?= Html::encode($this->title) ?></h1>
<p> <?= $nameUser ?></p>
<table border="1">   
   <tr> <th>user_id</th>  
        <th>Firstname</th>   
        <th>Lastname</th>   
        <th>Preffered Job Roles</th>   
    </tr>   
    <?php foreach($model as $field){ ?>   
    <tr>   
    <td><?= $field->user_id; ?></td>   
        <td><?= $field->firstname; ?></td>   
        <td><?= $field->lastname; ?></td>   
        <td><?= $field->preferred_job_roles; ?></td>   
    </tr>   
    <?php } ?>
    <code><?= __FILE__ ?></code>  
</table>