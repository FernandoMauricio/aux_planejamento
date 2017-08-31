<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Url;
use kartik\depdrop\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Precificacao */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="precificacao-form">

<?php

//Pega as mensagens
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

?>

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
                    <?= $form->field($model, 'unidade')->textInput(['value' => $model->unidade->uni_nomeabreviado,'readonly' => true]) ?>
                </div>

                <div class="col-md-4">
                  <?= $form->field($model, 'plano')->textInput(['value' => $model->planodeacao->plan_descricao,'readonly' => true]) ?>
                </div>

                <div class="col-md-2">
                    <?= $form->field($model, 'planp_cargahoraria')->textInput(['readonly' => true]) ?>
                </div>

                <div class="col-md-2">
                    <?= $form->field($model, 'planp_qntaluno')->textInput(['readonly' => true]) ?>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'planp_observacao')->textarea(['rows' => '3']) ?>
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
                <div class="col-md-6">
                    <?= $form->field($model, 'nivelDocente')->textInput(['value' => $model->despesasdocente->doce_descricao, 'readonly' => true]) ?>
                </div>

                <div class="col-md-2">
                    <?= $form->field($model, 'planp_totalhorasdocente')->textInput(['readonly' => true]) ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'planp_servpedagogico')->textInput(['readonly' => true]) ?>

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
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control']
                    ]); ?>

                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'planp_totalcustodocente')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
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
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
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
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
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
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
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
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
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
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>

                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_totalencargos')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control']
                    ]); ?>

                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'planp_totalsalarioencargo')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'planp_diarias')->textInput(['readonly' => true]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_passagens')->textInput(['readonly' => true]); ?>
                </div>


                <div class="col-md-3">
                    <?= $form->field($model, 'planp_pessoafisica')->textInput(['readonly' => true]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_pessoajuridica')->textInput(['readonly' => true]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'planp_PJApostila')->textInput(['readonly' => true]); ?>

                    <?= $form->field($model, 'hiddenPJApostila')->hiddenInput()->label(false); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_custosmateriais')->textInput(['readonly' => true]); ?>

                    <?= $form->field($model, 'hiddenMaterialDidatico')->hiddenInput()->label(false); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_custosconsumo')->textInput(['readonly' => true]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_totalcustodireto')->textInput(['readonly' => true]); ?>
                </div>
            </div>


            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'planp_totalhoraaulacustodireto')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 3,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
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
                    <?= $form->field($model, 'planp_custosindiretos')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_ipca')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_reservatecnica')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_despesadm')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'planp_totalincidencias')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_totalcustoindireto')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'planp_despesatotal')->textInput(['readonly' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'planp_markdivisor')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_markmultiplicador')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-6">
                    <?= $form->field($model, 'planp_vendaturma')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'planp_vendaaluno')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_retorno')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_horaaulaaluno')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_porcentretorno')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>
            </div>

            <div class="row">

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_precosugerido')->textInput() ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_retornoprecosugerido')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_vendaturmasugerido')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_porcentretornosugerido')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>


            </div>


            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'planp_parcelas')->textInput() ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'planp_valorparcelas')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'value' => $model->planp_valorparcelas,
                            'alias' => 'decimal',
                            'digits' => 0,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

            <div class="col-md-2">
                <?= $form->field($model, 'planp_desconto')->textInput() ?>
            </div>

            <div class="col-md-3">
                <?= $form->field($model, 'planp_valorcomdesconto')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 0,
                            'prefix' => 'R$ ',
                            'groupSeparator' => '.',
                            'radixPoint' => ',',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
            </div>

            </div>

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'planp_minimoaluno')->textInput(['readonly' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->registerJsFile('@web/js/precificacao_update.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
