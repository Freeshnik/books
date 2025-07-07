<?php

namespace Main\Controllers;

use App\Forms\User\LoginForm;
use App\Forms\User\SignUpForm;
use Yii;
use yii\web\Controller;

/**
 *
 */
class AuthController extends Controller
{
    /**
     * @return \yii\web\Response|string
     */
    public function actionLogin(): \yii\web\Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response|string
     * @throws \yii\db\Exception
     */
    public function actionSignup(): \yii\web\Response|string
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout(): \yii\web\Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
