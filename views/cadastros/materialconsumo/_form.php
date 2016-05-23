<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\cadastros\Materialconsumo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="materialconsumo-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'matcon_descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'matcon_tipo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'matcon_valor')->textInput() ?>

    <?= $form->field($model, 'matcon_status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
