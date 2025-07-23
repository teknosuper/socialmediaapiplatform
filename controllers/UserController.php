<?php

namespace app\controllers;

use yii\rest\Controller;

class UserController extends Controller
{
    public function actionIndex()
    {
        return ['message' => 'This is the user index'];
    }
}
