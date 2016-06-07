<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\money\MaskMoney;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\solicitacoes\MaterialCopias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="material-copias-form">

    <?php $form = ActiveForm::begin(); ?>

<div class="row">

    <div class="col-md-5">

    <?= $form->field($model, 'matc_descricao')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="col-md-4">

    <?= $form->field($model, 'matc_curso')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="col-md-3">

    <?= $form->field($model, 'matc_centrocusto')->textInput(['maxlength' => true]) ?>

    </div>

 </div>

 <div class="row">

    <div class="col-md-2">

    <?= $form->field($model, 'matc_qtoriginais')->textInput() ?>

    </div>

    <div class="col-md-2">

    <?= $form->field($model, 'matc_qtexemplares')->textInput() ?>

    </div>

    <div class="col-md-2">

    <?= $form->field($model, 'matc_qteCopias')->textInput(['readonly'=>true]) ?>

    </div>

    <div class="col-md-2">

    <?= $form->field($model, 'matc_mono')->textInput() ?>

    </div>

    <div class="col-md-2">

    <?= $form->field($model, 'matc_color')->textInput() ?>

    </div>

    <div class="col-md-2">

    <?= $form->field($model, 'matc_qteTotal')->textInput(['readonly'=>true]) ?>

    </div>

 </div>

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> DADOS FINANCEIROS</h3>
      </div>
        <div class="panel-body">
        <p>** Valores definidos em Reais (R$)</p>
            <div class="row">
                <div class="col-md-3">
                <?= $form->field($model, 'matc_totalValorMono')->widget(MaskedInput::className(),[
                                'options' => ['readonly' => true, 'class' => 'form-control'],
                                'clientOptions' => [
                                    'alias' => 'numeric',
                                     'digits' => 2,
                                     'digitsOptional' => false,
                                     'radixPoint' => ',',
                                     'groupSeparator' => '.',
                                     'autoGroup' => true,
                                     'clearMaskOnLostFocus'=>true,
                                ],
                  ])
                ?>
                </div>
                <div class="col-md-3">
                <?= $form->field($model, 'matc_totalValorColor')->widget(MaskedInput::className(),[
                                'options' => ['readonly' => true, 'class' => 'form-control'],
                                'clientOptions' => [

                                    'alias' => 'numeric',
                                     'digits' => 2,
                                     'digitsOptional' => false,
                                     'radixPoint' => ',',
                                     'groupSeparator' => '.',
                                     'autoGroup' => true,
                                     'clearMaskOnLostFocus'=>true,
                                ],
                  ])
                ?>
                </div>
            </div> 
        </div>
     </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar Solicitação' : 'Atualizar Solicitação', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<<EOD
$(function() {
     $('#materialcopias-matc_qtoriginais').keyup(function() {  
        updateTotal();
    });

    $('#materialcopias-matc_qtexemplares').keyup(function() {  
        updateTotal();
    });

    $('#materialcopias-matc_mono').keyup(function() {  
        updateTotal();
    });

    $('#materialcopias-matc_color').keyup(function() {  
        updateTotal();
    });
    console.log(updateTotal);
    var updateTotal = function () {
      var matc_qtoriginais  = parseInt($('#materialcopias-matc_qtoriginais').val());
      var matc_qtexemplares = parseInt($('#materialcopias-matc_qtexemplares').val());
      var matc_mono         = parseInt($('#materialcopias-matc_mono').val());
      var matc_color        = parseInt($('#materialcopias-matc_color').val());

      var matc_qteCopias = matc_qtoriginais * matc_qtexemplares;
      var matc_qteTotal  = matc_mono + matc_color;

      var mono = 0.1;
      var color = 0.6;

      var matc_totalValorMono = (matc_qtexemplares * matc_mono) * mono;
      var matc_totalValorColor = (matc_qtexemplares * matc_color) * color;

    if (isNaN(matc_qteCopias) || matc_qteCopias < 0) {
        matc_qteCopias = '';
    }

    if (isNaN(matc_qteTotal) || matc_qteTotal < 0) {
        matc_qteTotal = '';
    }

    if (isNaN(matc_totalValorMono) || matc_totalValorMono < 0) {
        matc_totalValorMono = '';
    }

    if (isNaN(matc_totalValorColor) || matc_totalValorColor < 0) {
        matc_totalValorColor = '';
    }
    console.log(matc_qteCopias);
      $('#materialcopias-matc_qtecopias').val(matc_qteCopias);
      $('#materialcopias-matc_qtetotal').val(matc_qteTotal);

      $('#materialcopias-matc_totalvalormono').val(matc_totalValorMono);
      $('#materialcopias-matc_totalvalorcolor').val(matc_totalValorColor);
      console.log(matc_totalValorMono);
    };
 });
EOD;
$this->registerJs($script, yii\web\View::POS_END);      
?>