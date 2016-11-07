<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Planilhadecurso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planilhadecurso-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'placu_codeixo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codsegmento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codplano')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codtipoa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codnivel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codsegtip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_cargahorariaplano')->textInput() ?>

    <?= $form->field($model, 'placu_cargahorariarealizada')->textInput() ?>

    <?= $form->field($model, 'placu_cargahorariaarealizar')->textInput() ?>

    <?= $form->field($model, 'placu_codano')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codfinalidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codcategoria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codtipla')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_quantidadeturmas')->textInput() ?>

    <?= $form->field($model, 'placu_quantidadealunos')->textInput() ?>

    <?= $form->field($model, 'placu_quantidadeparcelas')->textInput() ?>

    <?= $form->field($model, 'placu_valormensalidade')->textInput() ?>

    <?= $form->field($model, 'placu_codsituacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'placu_codunidade')->textInput() ?>

    <?= $form->field($model, 'plcau_nomeunidade')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_quantidadealunospsg')->textInput() ?>

    <?= $form->field($model, 'placu_tipocalculo')->textInput() ?>

    <?= $form->field($model, 'placu_arquivolistamaterial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_listamaterialdoaluno')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_observacao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'placu_taxaretorno')->textInput() ?>

    <?= $form->field($model, 'placu_cargahorariavivencia')->textInput() ?>

    <?= $form->field($model, 'placu_quantidadealunosisentos')->textInput() ?>

    <?= $form->field($model, 'planilhadecurso_placucol')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codprogramacao')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
