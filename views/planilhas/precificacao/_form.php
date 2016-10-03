<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Precificacao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="precificacao-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Nova Precificação de Custo</h3>
          </div>
            <table class="table table-condensed table-hover">
              <thead>
                <tr class="info"><th colspan="12">SEÇÃO 1: Informações do Curso</th></tr>
              </thead>
            </table>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                    <?php
                        $data_unidades = ArrayHelper::map($unidades, 'uni_codunidade', 'uni_nomeabreviado');
                        echo $form->field($model, 'planp_codunidade')->widget(Select2::classname(), [
                                'data' =>  $data_unidades,
                                'options' => ['placeholder' => 'Selecione a Unidade...'],
                                'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                    ?>
                </div>

                <div class="col-md-4">
                    <?php
                        $data_planos = ArrayHelper::map($planos, 'plan_codplano', 'plan_descricao');
                        echo $form->field($model, 'planp_planodeacao')->widget(Select2::classname(), [
                                'data' =>  $data_planos,
                                'options' => ['id' => 'plano-id','placeholder' => 'Selecione o Curso...',
                                'onchange'=>'
                                      var select = this;
                                      $.getJSON( "'.Url::toRoute('/planilhas/precificacao/get-plano').'", { plano: $(this).val() } )
                                      .done(function( data ) {

                                             var $divPanelBody = $(select).parent().parent().parent().parent().parent();

                                             var $inputCustoPlano = $divPanelBody.find("input:eq(15)");

                                             $inputCustoPlano.val(data.plan_custoTotal);

                                          });
                                      '
                                ]]);
                ?>
                </div>

                <div class="col-md-2">
                <?= $form->field($model, 'planp_cargahoraria')->textInput() ?>
                </div>

                <div class="col-md-2">
                <?= $form->field($model, 'planp_qntaluno')->textInput() ?>
                </div>

            </div>
        </div>

            <table class="table table-condensed table-hover">
              <thead>
                <tr class="info"><th colspan="12">SEÇÃO 2: Cálculos de Custos Diretos</th></tr>
              </thead>
            </table>

        <div class="panel-body">
            <div class="row">

                <div class="col-md-4">

                <?php
                        $data_nivelDocente = ArrayHelper::map($nivelDocente, 'doce_id', 'doce_descricao');
                        echo $form->field($model, 'planp_docente')->widget(Select2::classname(), [
                                'data' =>  $data_nivelDocente,
                                'options' => ['id' => 'nivelDocente-id','placeholder' => 'Selecione o Nível do Docente...',
                                'onchange'=>'
                                      var select = this;
                                      $.getJSON( "'.Url::toRoute('/planilhas/precificacao/get-nivel-docente').'", { niveldocente: $(this).val() } )
                                      .done(function( data ) {

                                             var $divPanelBody = $(select).parent().parent().parent().parent().parent();

                                             var $inputPlanejamento = $divPanelBody.find("input:eq(4)");

                                             var $inputCustoindireto = $divPanelBody.find("input:eq(5)");

                                             $inputCustoindireto.val(data.doce_valorhoraaula);

                                             $inputPlanejamento.val(data.doce_planejamento);

                                          });
                                      '
                                ]]);
                ?>

                </div>

                <div class="col-md-2">

                <?= $form->field($model, 'planp_totalhorasdocente')->textInput() ?>

                </div>

                <div class="col-md-4">

                <?= $form->field($model, 'planp_servpedagogico')->textInput() ?>

                <?= $form->field($model, 'hiddenPlanejamento')->hiddenInput()->label(false); ?>

                </div>

            </div>


            <div class="row">

                <div class="col-md-3">

                <?= $form->field($model, 'planp_valorhoraaula')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control']
                    ]); ?>

                </div>

                <div class="col-md-3">

                <?= $form->field($model, 'planp_horaaulaplanejamento')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control']
                    ]); ?>

                </div>

                <div class="col-md-3">

                <?= $form->field($model, 'planp_totalcustodocente')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control']
                    ]); ?>

                </div>

            </div>

            <div class="row">

                <div class="col-md-3">

                <?= $form->field($model, 'planp_decimo')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control']
                    ]); ?>

                </div>

                <div class="col-md-3">

                <?= $form->field($model, 'planp_ferias')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control']
                    ]); ?>

                </div>

                <div class="col-md-3">

                <?= $form->field($model, 'planp_tercoferias')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control']
                    ]); ?>

                </div>

                <div class="col-md-3">

                <?= $form->field($model, 'planp_totalsalario')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control']
                    ]); ?>

                </div>

            </div>


            <div class="row">

                <div class="col-md-3">

                <?= $form->field($model, 'planp_encargos')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'value' => 32.7,'class' => 'form-control']
                    ]); ?>

                </div>

                <div class="col-md-3">

                <?= $form->field($model, 'planp_totalencargos')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control']
                    ]); ?>

                </div>

                <div class="col-md-3">

                <?= $form->field($model, 'planp_totalsalarioencargo')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => [ 'readonly' => true, 'class' => 'form-control' ]
                    ]); ?>

                </div>

            </div>

        </div>

            <table class="table table-condensed table-hover">
              <thead>
                <tr class="info"><th colspan="12">SEÇÃO 3: Cálculos de Custos Indiretos</th></tr>
              </thead>
            </table>

        <div class="panel-body">

            <div class="row">

                <div class="col-md-3">

                <?= $form->field($model, 'planp_diarias')->textInput() ?>

                </div>

                <div class="col-md-3">

                <?= $form->field($model, 'planp_passagens')->textInput() ?>

                </div>


                <div class="col-md-3">

                <?= $form->field($model, 'planp_pessoafisica')->textInput() ?>

                </div>

                <div class="col-md-3">

                <?= $form->field($model, 'planp_pessoajuridica')->textInput() ?>

                </div>
                  
            </div>
        </div>

</div>
    

    <?= $form->field($model, 'planp_totalcustodireto')->textInput() ?>

    <?= $form->field($model, 'planp_totalhoraaulacustodireto')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<<EOD
$(function() {
    $('#precificacao-hiddenplanejamento').keyup(function() {  
       updateTotal();
    });

    $('#precificacao-planp_servpedagogico').keyup(function() {  
       updateTotal();
    });

    $('#precificacao-planp_horaaulaplanejamento').keyup(function() {  
       updateTotal();
    });


    $('#precificacao-planp_totalhorasdocente').keyup(function() {  
       updateTotal();
    });


    $('#precificacao-planp_valorhoraaula').keyup(function() {  
       updateTotal();
    });

    var updateTotal = function () {

      var planp_totalhorasdocente    = parseFloat($('#precificacao-planp_totalhorasdocente').val());
      var planp_valorhoraaula        = parseFloat($('#precificacao-planp_valorhoraaula').val());
      var hiddenplanejamento         = parseFloat($('#precificacao-hiddenplanejamento').val());
      var planp_servpedagogico       = parseFloat($('#precificacao-planp_servpedagogico').val());
      var planp_horaaulaplanejamento = parseFloat($('#precificacao-planp_horaaulaplanejamento').val());


      //CÁLCULOS REALIZADOS
      var valor_servpedagogico  = planp_servpedagogico * hiddenplanejamento;
      var valorTotalMaoDeObra   = (planp_totalhorasdocente * planp_valorhoraaula) + valor_servpedagogico;
      var valorDecimo           = valorTotalMaoDeObra / 12;
      var valorTercoFerias      = valorTotalMaoDeObra / 12 / 3;
      var totalSalarios         = valorTotalMaoDeObra + valorDecimo + valorDecimo + valorTercoFerias;
      var totalEncargos         = (totalSalarios * 32.7) / 100;
      var totalSalariosEncargos = totalSalarios + totalEncargos;

        //OCULTAR O NAN
        if (isNaN(valor_servpedagogico) || valor_servpedagogico < 0) {
            valor_servpedagogico = '';
        }

        if (isNaN(valorTotalMaoDeObra) || valorTotalMaoDeObra < 0) {
            valorTotalMaoDeObra = '';
        }

        if (isNaN(valorDecimo) || valorDecimo < 0) {
            valorDecimo = '';
        }

      $('#precificacao-planp_horaaulaplanejamento').val(valor_servpedagogico); // Valor hora/aula Planejamento

      $('#precificacao-planp_totalcustodocente').val(valorTotalMaoDeObra); // Custo de Mão de Obra Direta

      $('#precificacao-planp_decimo').val(valorDecimo); // 1/12 de 13º

      $('#precificacao-planp_ferias').val(valorDecimo); // 1/12 de Férias

      $('#precificacao-planp_tercoferias').val(valorTercoFerias); // 1/12 de 1/3 de férias

      $('#precificacao-planp_totalsalario').val(totalSalarios); // Total de Salários

      $('#precificacao-planp_totalencargos').val(totalEncargos); // Total de Salários x 32.7% (encargos)

      $('#precificacao-planp_totalsalarioencargo').val(totalSalariosEncargos); // Total de Salários + Total de Encargos 

    };
 });
EOD;
$this->registerJs($script, yii\web\View::POS_END);      
?>