<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\solicitacao_precificacao\SolicitacaoPrecificacaoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="solicitacao-precificacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'solpre_id') ?>

    <?= $form->field($model, 'solpre_titulo') ?>

    <?= $form->field($model, 'solpre_cargahoraria') ?>

    <?= $form->field($model, 'solpre_qntaluno') ?>

    <?= $form->field($model, 'solpre_observacao') ?>

    <?php // echo $form->field($model, 'solpre_codplano') ?>

    <?php // echo $form->field($model, 'solpre_autorizacao') ?>

    <?php // echo $form->field($model, 'solpre_dataautorizacao') ?>

    <?php // echo $form->field($model, 'solpre_situacao') ?>

    <?php // echo $form->field($model, 'solpre_unidade') ?>

    <?php // echo $form->field($model, 'solpre_solicitante') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
