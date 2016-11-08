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

    <?php $form = ActiveForm::begin(); ?>

    <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Nova Planilha de Curso</h3>
          </div>
            <table class="table table-condensed table-hover">
              <thead>
                <tr class="info"><th colspan="12">SEÇÃO 1: Informações do Plano</th></tr>
              </thead>
            </table>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                    <?php
                        $EixoList=ArrayHelper::map(app\models\cadastros\Eixo::find()->all(), 'eix_codeixo', 'eix_descricao' ); 
                                    echo $form->field($model, 'placu_codeixo')->widget(Select2::classname(), [
                                            'data' =>  $EixoList,
                                            'options' => ['id' => 'cat-id','placeholder' => 'Selecione o Eixo...'],
                                            'pluginOptions' => [
                                                    'allowClear' => true
                                                ],
                                            ]);
                    ?>
                </div>
                <div class="col-md-3">
                    <?php
                        // Child # 1
                        echo $form->field($model, 'placu_codsegmento')->widget(DepDrop::classname(), [
                            'type'=>DepDrop::TYPE_SELECT2,
                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                            'options'=>['id'=>'subcat-id'],
                            'pluginOptions'=>[
                                'depends'=>['cat-id'],
                                'placeholder'=>'Selecione o Segmento...',
                                'initialize' => true,
                                'url'=>Url::to(['/planos/planodeacao/segmento'])
                            ]
                        ]);
                    ?>
                </div>
                <div class="col-md-6">
                    <?php 
                        // Child # 2
                        echo $form->field($model, 'placu_codplano')->widget(DepDrop::classname(), [
                            'type'=>DepDrop::TYPE_SELECT2,
                            'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                            'pluginOptions'=>[
                                'depends'=>['cat-id', 'subcat-id'],
                                'placeholder'=>'Selecione o Plano...',
                                'url'=>Url::to(['/planilhas/planilhadecurso/planos'])],
                                'options' => [
                                    'onchange'=>'
                                            var select = this;
                                            $.getJSON( "'.Url::toRoute('/planilhas/planilhadecurso/get-plano-detalhes').'", { planoId: $(this).val() } )
                                            .done(function( data ) {

                                                   var $divPanelBody =  $(select).parent().parent().parent().parent().parent();

                                                   console.log(data);
                                                   var $inputTipoacao = $divPanelBody.find("input:eq(1)");
                                                   var $inputNivel = $divPanelBody.find("input:eq(2)");
                                                   var $inputCargaHoraria = $divPanelBody.find("input:eq(3)");

                                                   $inputTipoacao.val(data.plan_codtipoa);
                                                   $inputNivel.val(data.plan_codnivel);
                                                   $inputCargaHoraria.val(data.plan_cargahoraria);

                                                });
                                            '
                                    ]]);
                    ?>
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
                <?php
                        $rows = Ano::find()->where(['an_status'=> 1])->orderBy('an_ano')->all();
                        $data_ano = ArrayHelper::map($rows, 'an_codano', 'an_ano');
                        echo $form->field($model, 'placu_codano')->widget(Select2::classname(), [
                                'data' =>  $data_ano,
                                'options' => ['placeholder' => 'Selecione o Ano...'],
                                'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                ?>
                </div>

                <div class="col-md-3">
                <?php
                        $rows = Tipoplanilha::find()->all();
                        $data_tipoplanilha = ArrayHelper::map($rows, 'tipla_codtipla', 'tipla_descricao');
                        echo $form->field($model, 'placu_codtipla')->widget(Select2::classname(), [
                                'data' =>  $data_tipoplanilha,
                                'options' => ['placeholder' => 'Tipo de Planilha...'],
                                'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                ?>
                </div>

                <div class="col-md-3">
                <?php
                        $rows = Tipoprogramacao::find()->all();
                        $data_tipoprogramacao = ArrayHelper::map($rows, 'tipro_codprogramacao', 'tipro_descricao');
                        echo $form->field($model, 'placu_codprogramacao')->widget(Select2::classname(), [
                                'data' =>  $data_tipoprogramacao,
                                'options' => ['placeholder' => 'Tipo de Programação...'],
                                'pluginOptions' => [
                                        'allowClear' => true
                                    ],
                                ]);
                ?>
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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>