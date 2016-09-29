<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\PrecificacaoSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="precificacao-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'planp_id') ?>

    <?= $form->field($model, 'planp_codunidade') ?>

    <?= $form->field($model, 'planp_planodeacao') ?>

    <?= $form->field($model, 'planp_cargahoraria') ?>

    <?= $form->field($model, 'planp_qntaluno') ?>

    <?php // echo $form->field($model, 'planp_totalhorasdocente') ?>

    <?php // echo $form->field($model, 'planp_docente') ?>

    <?php // echo $form->field($model, 'planp_valorhoraaula') ?>

    <?php // echo $form->field($model, 'planp_servpedagogico') ?>

    <?php // echo $form->field($model, 'planp_horaaulaplanejamento') ?>

    <?php // echo $form->field($model, 'planp_totalcustodocente') ?>

    <?php // echo $form->field($model, 'planp_decimo') ?>

    <?php // echo $form->field($model, 'planp_ferias') ?>

    <?php // echo $form->field($model, 'planp_tercoferias') ?>

    <?php // echo $form->field($model, 'planp_totalsalario') ?>

    <?php // echo $form->field($model, 'planp_encargos') ?>

    <?php // echo $form->field($model, 'planp_totalencargos') ?>

    <?php // echo $form->field($model, 'planp_totalsalarioencargo') ?>

    <?php // echo $form->field($model, 'planp_diarias') ?>

    <?php // echo $form->field($model, 'planp_passagens') ?>

    <?php // echo $form->field($model, 'planp_pessoafisica') ?>

    <?php // echo $form->field($model, 'planp_pessoajuridica') ?>

    <?php // echo $form->field($model, 'planp_totalcustodireto') ?>

    <?php // echo $form->field($model, 'planp_totalhoraaulacustodireto') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
