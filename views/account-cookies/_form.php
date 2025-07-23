<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\AccountCookies $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="account-cookies-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'service')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cookie')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'cookies_status')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cookies_response')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
