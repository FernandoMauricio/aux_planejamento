<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\PlanilhadecursoAdminSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planilhadecurso-admin-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'placu_codplanilha') ?>

    <?= $form->field($model, 'placu_codeixo') ?>

    <?= $form->field($model, 'placu_codsegmento') ?>

    <?= $form->field($model, 'placu_codplano') ?>

    <?= $form->field($model, 'placu_codtipoa') ?>

    <?php // echo $form->field($model, 'placu_codnivel') ?>

    <?php // echo $form->field($model, 'placu_cargahorariaplano') ?>

    <?php // echo $form->field($model, 'placu_cargahorariarealizada') ?>

    <?php // echo $form->field($model, 'placu_cargahorariaarealizar') ?>

    <?php // echo $form->field($model, 'placu_codano') ?>

    <?php // echo $form->field($model, 'placu_codcategoria') ?>

    <?php // echo $form->field($model, 'placu_codtipla') ?>

    <?php // echo $form->field($model, 'placu_quantidadeturmas') ?>

    <?php // echo $form->field($model, 'placu_quantidadealunos') ?>

    <?php // echo $form->field($model, 'placu_quantidadeparcelas') ?>

    <?php // echo $form->field($model, 'placu_valormensalidade') ?>

    <?php // echo $form->field($model, 'placu_codsituacao') ?>

    <?php // echo $form->field($model, 'placu_codcolaborador') ?>

    <?php // echo $form->field($model, 'placu_codunidade') ?>

    <?php // echo $form->field($model, 'placu_nomeunidade') ?>

    <?php // echo $form->field($model, 'placu_quantidadealunospsg') ?>

    <?php // echo $form->field($model, 'placu_tipocalculo') ?>

    <?php // echo $form->field($model, 'placu_observacao') ?>

    <?php // echo $form->field($model, 'placu_taxaretorno') ?>

    <?php // echo $form->field($model, 'placu_cargahorariavivencia') ?>

    <?php // echo $form->field($model, 'placu_quantidadealunosisentos') ?>

    <?php // echo $form->field($model, 'placu_codprogramacao') ?>

    <?php // echo $form->field($model, 'placu_totalcustodocente') ?>

    <?php // echo $form->field($model, 'placu_decimo') ?>

    <?php // echo $form->field($model, 'placu_ferias') ?>

    <?php // echo $form->field($model, 'placu_tercoferias') ?>

    <?php // echo $form->field($model, 'placu_totalsalario') ?>

    <?php // echo $form->field($model, 'placu_encargos') ?>

    <?php // echo $form->field($model, 'placu_totalencargos') ?>

    <?php // echo $form->field($model, 'placu_totalsalarioencargo') ?>

    <?php // echo $form->field($model, 'placu_custosmateriais') ?>

    <?php // echo $form->field($model, 'placu_hiddenmaterialdidatico') ?>

    <?php // echo $form->field($model, 'placu_custosconsumo') ?>

    <?php // echo $form->field($model, 'placu_diarias') ?>

    <?php // echo $form->field($model, 'placu_passagens') ?>

    <?php // echo $form->field($model, 'placu_pessoafisica') ?>

    <?php // echo $form->field($model, 'placu_pessoajuridica') ?>

    <?php // echo $form->field($model, 'placu_equipamentos') ?>

    <?php // echo $form->field($model, 'placu_PJApostila') ?>

    <?php // echo $form->field($model, 'placu_hiddenpjapostila') ?>

    <?php // echo $form->field($model, 'placu_totalcustodireto') ?>

    <?php // echo $form->field($model, 'placu_totalhoraaulacustodireto') ?>

    <?php // echo $form->field($model, 'placu_custosindiretos') ?>

    <?php // echo $form->field($model, 'placu_ipca') ?>

    <?php // echo $form->field($model, 'placu_reservatecnica') ?>

    <?php // echo $form->field($model, 'placu_despesadm') ?>

    <?php // echo $form->field($model, 'placu_totalincidencias') ?>

    <?php // echo $form->field($model, 'placu_totalcustoindireto') ?>

    <?php // echo $form->field($model, 'placu_despesatotal') ?>

    <?php // echo $form->field($model, 'placu_markdivisor') ?>

    <?php // echo $form->field($model, 'placu_markmultiplicador') ?>

    <?php // echo $form->field($model, 'placu_vendaturma') ?>

    <?php // echo $form->field($model, 'placu_vendaaluno') ?>

    <?php // echo $form->field($model, 'placu_horaaulaaluno') ?>

    <?php // echo $form->field($model, 'placu_retorno') ?>

    <?php // echo $form->field($model, 'placu_porcentretorno') ?>

    <?php // echo $form->field($model, 'placu_precosugerido') ?>

    <?php // echo $form->field($model, 'placu_retornoprecosugerido') ?>

    <?php // echo $form->field($model, 'placu_minimoaluno') ?>

    <?php // echo $form->field($model, 'placu_parcelas') ?>

    <?php // echo $form->field($model, 'placu_valorparcelas') ?>

    <?php // echo $form->field($model, 'placu_data') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
