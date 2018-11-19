<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\solicitacao_precificacao\SolicitacaoPrecificacao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitacao-precificacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'solpre_titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'solpre_cargahoraria')->textInput() ?>

    <?= $form->field($model, 'solpre_qntaluno')->textInput() ?>

    <?= $form->field($model, 'solpre_observacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'solpre_codplano')->textInput() ?>

    <?= $form->field($model, 'solpre_autorizacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'solpre_dataautorizacao')->textInput() ?>

    <?= $form->field($model, 'solpre_situacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'solpre_unidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'solpre_solicitante')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
