<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\PlanilhadecursoAdmin */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planilhadecurso-admin-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'placu_codeixo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codsegmento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codplano')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codtipoa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codnivel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_cargahorariaplano')->textInput() ?>

    <?= $form->field($model, 'placu_cargahorariarealizada')->textInput() ?>

    <?= $form->field($model, 'placu_cargahorariaarealizar')->textInput() ?>

    <?= $form->field($model, 'placu_codano')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codcategoria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codtipla')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_quantidadeturmas')->textInput() ?>

    <?= $form->field($model, 'placu_quantidadealunos')->textInput() ?>

    <?= $form->field($model, 'placu_quantidadeparcelas')->textInput() ?>

    <?= $form->field($model, 'placu_valormensalidade')->textInput() ?>

    <?= $form->field($model, 'placu_codsituacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'placu_codunidade')->textInput() ?>

    <?= $form->field($model, 'placu_nomeunidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_quantidadealunospsg')->textInput() ?>

    <?= $form->field($model, 'placu_tipocalculo')->textInput() ?>

    <?= $form->field($model, 'placu_observacao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'placu_taxaretorno')->textInput() ?>

    <?= $form->field($model, 'placu_cargahorariavivencia')->textInput() ?>

    <?= $form->field($model, 'placu_quantidadealunosisentos')->textInput() ?>

    <?= $form->field($model, 'placu_codprogramacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_totalcustodocente')->textInput() ?>

    <?= $form->field($model, 'placu_decimo')->textInput() ?>

    <?= $form->field($model, 'placu_ferias')->textInput() ?>

    <?= $form->field($model, 'placu_tercoferias')->textInput() ?>

    <?= $form->field($model, 'placu_totalsalario')->textInput() ?>

    <?= $form->field($model, 'placu_encargos')->textInput() ?>

    <?= $form->field($model, 'placu_totalencargos')->textInput() ?>

    <?= $form->field($model, 'placu_totalsalarioencargo')->textInput() ?>

    <?= $form->field($model, 'placu_custosmateriais')->textInput() ?>

    <?= $form->field($model, 'placu_hiddenmaterialdidatico')->textInput() ?>

    <?= $form->field($model, 'placu_custosconsumo')->textInput() ?>

    <?= $form->field($model, 'placu_diarias')->textInput() ?>

    <?= $form->field($model, 'placu_passagens')->textInput() ?>

    <?= $form->field($model, 'placu_pessoafisica')->textInput() ?>

    <?= $form->field($model, 'placu_pessoajuridica')->textInput() ?>

    <?= $form->field($model, 'placu_equipamentos')->textInput() ?>

    <?= $form->field($model, 'placu_PJApostila')->textInput() ?>

    <?= $form->field($model, 'placu_hiddenpjapostila')->textInput() ?>

    <?= $form->field($model, 'placu_totalcustodireto')->textInput() ?>

    <?= $form->field($model, 'placu_totalhoraaulacustodireto')->textInput() ?>

    <?= $form->field($model, 'placu_custosindiretos')->textInput() ?>

    <?= $form->field($model, 'placu_ipca')->textInput() ?>

    <?= $form->field($model, 'placu_reservatecnica')->textInput() ?>

    <?= $form->field($model, 'placu_despesadm')->textInput() ?>

    <?= $form->field($model, 'placu_totalincidencias')->textInput() ?>

    <?= $form->field($model, 'placu_totalcustoindireto')->textInput() ?>

    <?= $form->field($model, 'placu_despesatotal')->textInput() ?>

    <?= $form->field($model, 'placu_markdivisor')->textInput() ?>

    <?= $form->field($model, 'placu_markmultiplicador')->textInput() ?>

    <?= $form->field($model, 'placu_vendaturma')->textInput() ?>

    <?= $form->field($model, 'placu_vendaaluno')->textInput() ?>

    <?= $form->field($model, 'placu_horaaulaaluno')->textInput() ?>

    <?= $form->field($model, 'placu_retorno')->textInput() ?>

    <?= $form->field($model, 'placu_porcentretorno')->textInput() ?>

    <?= $form->field($model, 'placu_precosugerido')->textInput() ?>

    <?= $form->field($model, 'placu_retornoprecosugerido')->textInput() ?>

    <?= $form->field($model, 'placu_minimoaluno')->textInput() ?>

    <?= $form->field($model, 'placu_parcelas')->textInput() ?>

    <?= $form->field($model, 'placu_valorparcelas')->textInput() ?>

    <?= $form->field($model, 'placu_data')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
