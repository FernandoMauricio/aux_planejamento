<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\despesas\Custosunidade */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="custosunidade-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

<div class="row">
    <div class="col-md-10">
    <?php
            $data_unidades = ArrayHelper::map($unidades, 'uni_codunidade', 'uni_nomeabreviado');
            echo $form->field($model, 'cust_codunidade')->widget(Select2::classname(), [
                    'data' =>  $data_unidades,
                    'options' => ['id' => 'unidade-id', 'placeholder' => 'Selecione a Unidade...'],
                    'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
    ?>
    </div>

    <div class="col-md-2">
    <?= $form->field($model, 'cust_status')->radioList(['1' => 'Ativo', '0' => 'Inativo']) ?>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
    <?= $this->render('_form-custoindireto', [
        'form' => $form,
        'salas' => $salas,
        'modelsCustosIndireto' => $modelsCustosIndireto 
        ]) 
    ?>
</div>
   
</div>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
