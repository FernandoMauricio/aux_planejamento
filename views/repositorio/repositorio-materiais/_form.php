<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\repositorio\Repositorio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="repositorio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'rep_titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_categoria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_editora')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_valor')->textInput() ?>

    <?= $form->field($model, 'rep_sobre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_arquivo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'rep_codunidade')->textInput() ?>

    <?= $form->field($model, 'rep_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'rep_data')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
