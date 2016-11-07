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
                        <div class="col-md-12">
                            <?= $form->field($model, 'PlanoLabel')->textInput(['value'=> $model->plano->plan_descricao,'readonly'=>true]) ?>
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

        <div class="panel-body">
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
                    <?= $form->field($model, 'placu_transporte')->textInput() ?>
                </div>
            </div>
        </div>


    <?= $form->field($model, 'placu_quantidadeparcelas')->textInput() ?>

    <?= $form->field($model, 'placu_valormensalidade')->textInput() ?>

    <?= $form->field($model, 'placu_tipocalculo')->textInput() ?>

    <?= $form->field($model, 'placu_observacao')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'placu_taxaretorno')->textInput() ?>


    <?= $form->field($model, 'placu_codcategoria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codsituacao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'placu_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'placu_codunidade')->textInput() ?>

    <?= $form->field($model, 'placu_nomeunidade')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'planilhadecurso_placucol')->textInput(['maxlength' => true]) ?>

</div>
