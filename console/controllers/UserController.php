<?php


namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;

class UserController extends Controller
{

    public function actionCreate()
    {
        $user = new User();
        $user::deleteAll();

        $user->username = 'admin';
        $user->generateAuthKey();
        $user->password = 'admin';
        $user->email='admin@example.com';
        $user->save(false);

        exit("Done: User admin has been created\n");

    }

}