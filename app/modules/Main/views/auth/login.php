<?php

/** @var yii\web\View $this */
/** @var ActiveForm $form */
/** @var LoginForm $model */

use App\Forms\User\LoginForm;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Пожалуйста, заполните следующие поля для входа:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                <?= $form->field($model, 'username')->label('Имя пользователя')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->label('Пароль')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->label('Запомнить меня')->checkbox() ?>

                <div class="form-group">
                    <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
