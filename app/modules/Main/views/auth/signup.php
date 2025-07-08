<?php

/** @var yii\web\View $this */
/** @var ActiveForm $form */
/** @var SignupForm $model */

use App\Forms\User\SignUpForm;
use App\Models\User;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Для регистрации заполните, пожалуйста, следующие поля:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'fio')->textInput() ?>

                <?= $form->field($model, 'phone')->textInput() ?>

                <?= $form->field($model, 'type')->dropDownList(User::getTypes()) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <div class="form-group">
                    <?= Html::submitButton('Применить', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
