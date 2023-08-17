<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$userId = Yii::$app->user->identity->id;
$items =['Software Engineer','Software Quality Engineer','Designer Engineer'];
?>


<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'user_id')->textInput(['readonly' => true, 'value' => $userId]) ?>
<?= $form->field($model, 'firstname'); ?>
<?= $form->field($model, 'lastname'); ?>
<?= $form->field($model, 'remember_me')->textInput(['placeholder' => "yes/no"]) ?>
<?= $form->field($model, 'country_code'); ?>
<?= $form->field($model, 'phone_number'); ?>
<?= $form->field($model, 'resume_doc'); ?>
<?= $form->field($model, 'portfolio_url'); ?>
<?= $form->field($model, 'preferred_job_roles')->dropDownList($items); ?>
<?= $form->field($model, 'employee_referral_name'); ?>
<?= $form->field($model, 'send_job_updates')->textInput(['placeholder' => "yes/no"]) ?>

<?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']); ?>

<?php ActiveForm::end(); ?>
<?php  ?>