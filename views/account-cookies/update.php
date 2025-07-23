<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AccountCookies $model */

$this->title = 'Update Account Cookies: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Account Cookies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="account-cookies-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
