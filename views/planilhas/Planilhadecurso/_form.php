<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Planilhadecurso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planilhadecurso-form">

    <?php $form = ActiveForm::begin(); ?>

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

                            <?php 
                                // Child # 2
                                echo $form->field($model, 'placu_codplano')->widget(DepDrop::classname(), [
                                    'type'=>DepDrop::TYPE_SELECT2,
                                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                    'pluginOptions'=>[
                                        'depends'=>['cat-id', 'subcat-id'],
                                        'placeholder'=>'Selecione o Plano...',
                                        'url'=>Url::to(['/planilhas/planilhadecurso/planos'])
                                    ]
                                ]);
                            ?>

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
