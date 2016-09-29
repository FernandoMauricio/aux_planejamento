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


<?php
            // $data_unidades = ArrayHelper::map($unidades, 'uni_codunidade', 'uni_nomeabreviado');
            // echo $form->field($model, 'planp_codunidade')->widget(Select2::classname(), [
            //         'data' =>  $data_unidades,
            //         'options' => ['id' => 'unidade-id','placeholder' => 'Selecione a Unidade...',
            //         'onchange'=>'
            //                     var select = this;
            //                     $.getJSON( "'.Url::toRoute('/planilhas/precificacao/get-custo-unidade').'", { custounidade: $(this).val() } )
            //                     .done(function( data ) {

            //                            var $divPanelBody = $(select).parent().parent().parent().parent().parent();

            //                            var $inputCustoindireto = $divPanelBody.find("input:eq(2)");
                                       
            //                            $inputCustoindireto.val(data.cust_MediaPorcentagem);

            //                            console.log(data.cust_MediaPorcentagem);
                                       
            //                         });
            //                     '
            //               ]]);
?>

<div class="row">
    <div class="col-md-5">
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

    <div class="col-md-5">
        <?php
            $data_planos = ArrayHelper::map($planos, 'plan_codplano', 'plan_descricao');
            echo $form->field($model, 'planp_planodeacao')->widget(Select2::classname(), [
                    'data' =>  $data_planos,
                    'options' => ['placeholder' => 'Selecione o Curso...'],
                    'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
        ?>
    </div>

    <div class="col-md-2">
    <?= $form->field($model, 'planp_cargahoraria')->textInput() ?>
    </div>
</div>


    <?= $form->field($model, 'planp_qntaluno')->textInput() ?>

    <?= $form->field($model, 'planp_totalhorasdocente')->textInput() ?>

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

                                 var $inputCustoindireto = $divPanelBody.find("input:eq(4)");
                                 
                                 $inputCustoindireto.val(data.doce_valorhoraaula);

                              });
                          '
                    ]]);
    ?>

    <?= $form->field($model, 'planp_valorhoraaula')->widget(\yii\widgets\MaskedInput::className(), [
                'clientOptions' => [
                'alias' => 'decimal',
                'digits' => 2,
                ]
        ]); ?>

    <?= $form->field($model, 'planp_servpedagogico')->textInput() ?>

    <?= $form->field($model, 'planp_horaaulaplanejamento')->textInput() ?>

    <?= $form->field($model, 'planp_totalcustodocente')->textInput() ?>

    <?= $form->field($model, 'planp_decimo')->textInput() ?>

    <?= $form->field($model, 'planp_ferias')->textInput() ?>

    <?= $form->field($model, 'planp_tercoferias')->textInput() ?>

    <?= $form->field($model, 'planp_totalsalario')->textInput() ?>

    <?= $form->field($model, 'planp_encargos')->textInput() ?>

    <?= $form->field($model, 'planp_totalencargos')->textInput() ?>

    <?= $form->field($model, 'planp_totalsalarioencargo')->textInput() ?>

    <?= $form->field($model, 'planp_diarias')->textInput() ?>

    <?= $form->field($model, 'planp_passagens')->textInput() ?>

    <?= $form->field($model, 'planp_pessoafisica')->textInput() ?>

    <?= $form->field($model, 'planp_pessoajuridica')->textInput() ?>

    <?= $form->field($model, 'planp_totalcustodireto')->textInput() ?>

    <?= $form->field($model, 'planp_totalhoraaulacustodireto')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
