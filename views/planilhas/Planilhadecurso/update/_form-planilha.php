<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

use app\models\cadastros\Ano;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Tipoprogramacao;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Planilhadecurso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planilhadecurso-form">

            <table class="table table-condensed table-hover">
              <thead>
                <tr class="info"><th colspan="12">SEÇÃO 1: Informações do Plano</th></tr>
              </thead>
            </table>

        <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <?= $form->field($model, 'nivelLabel')->textInput(['value'=> $model->nivel->niv_descricao,'readonly'=>true]) ?>
                        </div>

                        <div class="col-md-3">
                            <?= $form->field($model, 'eixoLabel')->textInput(['value'=> $model->eixo->eix_descricao,'readonly'=>true]) ?>
                        </div>

                        <div class="col-md-3">
                            <?= $form->field($model, 'segmentoLabel')->textInput(['value'=> $model->segmento->seg_descricao,'readonly'=>true]) ?>
                        </div>

                        <div class="col-md-3">
                            <?= $form->field($model, 'tipoAcaoLabel')->textInput(['value'=> $model->tipo->tip_descricao,'readonly'=>true]) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-9">
                            <?= $form->field($model, 'PlanoLabel')->textInput(['value'=> $model->plano->plan_descricao,'readonly'=>true]) ?>
                        </div>

                        <div class="col-md-3">
                            <?= $form->field($model, 'placu_cargahorariaplano')->textInput(['readonly'=>true]) ?>
                        </div>
                    </div>
        </div>

            <table class="table table-condensed table-hover">
              <thead>
                <tr class="info"><th colspan="12">SEÇÃO 2: Sobre a Turma</th></tr>
              </thead>
            </table>

        <div class="panel-body">

            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'anoLabel')->textInput(['value'=> $model->tipoprogramacao->tipro_descricao,'readonly'=>true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'tipoPlanilhaLabel')->textInput(['value'=> $model->tipoplanilha->tipla_descricao,'readonly'=>true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'tipoProgramacaoLabel')->textInput(['value'=> $model->tipoprogramacao->tipro_descricao,'readonly'=>true]) ?>
                </div>

                <div class="col-md-3">
                    <?= $form->field($model, 'placu_quantidadeturmas')->textInput() ?>
                </div>

            </div>

        <?= $form->field($model, 'placu_codtipoa')->hiddenInput()->label(false); ?>

        <?= $form->field($model, 'placu_codnivel')->hiddenInput()->label(false); ?>

        <?= $form->field($model, 'placu_cargahorariaplano')->hiddenInput()->label(false); ?>


            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'placu_cargahorariarealizada')->textInput() ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'placu_cargahorariaarealizar')->textInput() ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'placu_cargahorariavivencia')->textInput() ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'placu_quantidadealunos')->textInput() ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'placu_quantidadealunosisentos')->textInput() ?>
                </div>

                <div class="col-md-4">
                    <?= $form->field($model, 'placu_quantidadealunospsg')->textInput() ?>
                </div>
            </div>

        </div>

            <table class="table table-condensed table-hover">
              <thead>
                <tr class="info"><th colspan="12">SEÇÃO 3: Cálculos de Custos Diretos</th></tr>
              </thead>
            </table>

                    <!-- Renderiza Despesas com Docente -->
                    <?= $this->render('_form-despesadocente', [
                        'form' => $form,
                        'modelsPlaniDespDocente' => $modelsPlaniDespDocente,
                    ]) ?>


        <div class="panel-body">

            <div class="row">

                <div class="col-md-3">
                <?= $form->field($model, 'placu_totalcustodocente')->widget(\yii\widgets\MaskedInput::className(), [
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

                <div class="col-md-2">
                <?= $form->field($model, 'placu_decimo')->widget(\yii\widgets\MaskedInput::className(), [
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

                <div class="col-md-2">
                <?= $form->field($model, 'placu_ferias')->widget(\yii\widgets\MaskedInput::className(), [
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

                <div class="col-md-2">
                <?= $form->field($model, 'placu_tercoferias')->widget(\yii\widgets\MaskedInput::className(), [
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
                <?= $form->field($model, 'placu_totalsalario')->widget(\yii\widgets\MaskedInput::className(), [
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
                <?= $form->field($model, 'placu_encargos')->widget(\yii\widgets\MaskedInput::className(), [
                            'clientOptions' => [
                            'alias' => 'decimal',
                            'digits' => 2,
                            'suffix' => '%',
                            'autoGroup' => true,
                            'removeMaskOnSubmit' => true,
                            ],
                            'options' => ['value'=> 32.7, 'readonly' => true, 'class' => 'form-control' ]
                    ]); ?>
                </div>

                <div class="col-md-3">
                <?= $form->field($model, 'placu_totalencargos')->widget(\yii\widgets\MaskedInput::className(), [
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
                <?= $form->field($model, 'placu_totalsalarioencargo')->widget(\yii\widgets\MaskedInput::className(), [
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
                <?= $form->field($model, 'placu_diarias')->textInput(['value' => 0]) ?>
                </div>

                <div class="col-md-3">
                <?= $form->field($model, 'placu_passagens')->textInput(['value' => 0]) ?>
                </div>


                <div class="col-md-3">
                <?= $form->field($model, 'placu_pessoafisica')->textInput(['value' => 0]) ?>
                </div>

                <div class="col-md-3">
                <?= $form->field($model, 'placu_pessoajuridica')->textInput(['value' => 0]) ?>
                </div>

            </div>

            <div class="row">

                <div class="col-md-3">
                <?= $form->field($model, 'placu_PJApostila')->widget(\yii\widgets\MaskedInput::className(), [
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

                <?= $form->field($model, 'placu_hiddenpjapostila')->hiddenInput()->label(false); ?>
                </div>

                <div class="col-md-3">
                <?= $form->field($model, 'placu_custosmateriais')->widget(\yii\widgets\MaskedInput::className(), [
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

                <?= $form->field($model, 'placu_hiddenmaterialdidatico')->hiddenInput()->label(false); ?>
                </div>

                <div class="col-md-3">
                <?= $form->field($model, 'placu_custosconsumo')->widget(\yii\widgets\MaskedInput::className(), [
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
                <?= $form->field($model, 'placu_totalcustodireto')->widget(\yii\widgets\MaskedInput::className(), [
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
                <?= $form->field($model, 'placu_totalhoraaulacustodireto')->widget(\yii\widgets\MaskedInput::className(), [
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


<!--         <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <?= $form->field($model, 'placu_diarias')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'placu_equipamentos')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'placu_pessoajuridica')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'placu_passagens')->textInput() ?>
                </div>
            </div>
        </div>
 -->

<!--     <?= $form->field($model, 'placu_quantidadeparcelas')->textInput() ?>

    <?= $form->field($model, 'placu_valormensalidade')->textInput() ?>

    <?= $form->field($model, 'placu_tipocalculo')->textInput() ?>

    <?= $form->field($model, 'placu_observacao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'placu_taxaretorno')->textInput() ?>


    <?= $form->field($model, 'placu_codcategoria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codsituacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'placu_codunidade')->textInput() ?>

    <?= $form->field($model, 'placu_nomeunidade')->textInput(['maxlength' => true]) ?>


 -->

            <table class="table table-condensed table-hover">
              <thead>
                <tr class="info"><th colspan="12">SEÇÃO 4: Cálculos de Custos Indiretos</th></tr>
              </thead>
            </table>

</div>

<?php $this->registerJsFile(Yii::$app->request->baseUrl.'/js/planilhadecurso.js', ['position'=>$this::POS_READY]); ?>