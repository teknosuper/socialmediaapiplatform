<?php

namespace app\controllers;

use yii\web\Controller;

class DocumentationController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
