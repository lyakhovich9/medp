<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Reception $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reception-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'patient_fio')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_of_reception')->textInput() ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
