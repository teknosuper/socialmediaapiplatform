<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\AccountCookies $model */

$this->title = 'Create Account Cookies';
$this->params['breadcrumbs'][] = ['label' => 'Account Cookies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-cookies-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
