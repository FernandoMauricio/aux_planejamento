<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Json;
use app\models\cadastros\Eixo;
use app\models\cadastros\Segmento;

/* @var $this yii\web\View */
/* @var $model app\models\planos\Planodeacao */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="planodeacao-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

                    <div class="row">
                        <div class="col-md-10">

                        <?= $form->field($model, 'plan_descricao')->textInput(['maxlength' => true]) ?>

                         </div>

                         <div class="col-md-2">

                        <?= $form->field($model, 'plan_cargahoraria')->textInput(['maxlength' => true]) ?>

                         </div>

                        <div class="col-md-3">
                            <?php
                            $nivelList=ArrayHelper::map(app\models\cadastros\Nivel::find()->all(), 'niv_codnivel', 'niv_descricao' ); 
                                        echo $form->field($model, 'plan_codnivel')->widget(Select2::classname(), [
                                                'data' =>  $nivelList,
                                                'options' => ['placeholder' => 'Selecione o Nivel...'],
                                                'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]);
                            ?>

                        </div>

                        <div class="col-md-3">
                            <?php
                                $EixoList=ArrayHelper::map(app\models\cadastros\Eixo::find()->all(), 'eix_codeixo', 'eix_descricao' ); 
                                            echo $form->field($model, 'plan_codeixo')->widget(Select2::classname(), [
                                                    'data' =>  $EixoList,
                                                    'options' => ['id' => 'eixo-id','placeholder' => 'Selecione o Eixo...'],
                                                    'pluginOptions' => [
                                                            'allowClear' => true
                                                        ],
                                                    ]);


                            ?>
                        </div>

                        <div class="col-md-3">
                            <?php
                                // Child # 1
                                echo $form->field($model, 'plan_codsegmento')->widget(DepDrop::classname(), [
                                    'type'=>DepDrop::TYPE_SELECT2,
                                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                    'options'=>['id'=>'segmento-id'],
                                    'pluginOptions'=>[
                                        'depends'=>['eixo-id'],
                                        'placeholder'=>'Selecione o Segmento...',
                                        'url'=>Url::to(['/planos/planodeacao/segmento'])
                                    ]
                                ]);


                            ?>
                        </div>

                        <div class="col-md-3">
                            <?php
                                // Child # 2
                                echo $form->field($model, 'plan_codtipoa')->widget(DepDrop::classname(), [
                                    'type'=>DepDrop::TYPE_SELECT2,
                                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                    'pluginOptions'=>[
                                        'depends'=>['segmento-id'],
                                        'placeholder'=>'Selecione o Tipo de Ação...',
                                        'url'=>Url::to(['/planos/planodeacao/tipos'])
                                    ]
                                ]);
                            ?>
                        </div>

                      </div>

                        <?= $form->field($model, 'plan_sobre')->textarea(['rows' => 6]) ?>

                        <?= $form->field($model, 'plan_prerequisito')->textarea(['rows' => 6]) ?>

                        <?= $form->field($model, 'plan_orgcurricular')->textarea(['rows' => 6]) ?>

                        <?= $form->field($model, 'plan_perfTecnico')->textarea(['rows' => 6]) ?>

                        <?= $form->field($model, 'plan_matConsumo')->textarea(['rows' => 6]) ?>

                        <?= $form->field($model, 'plan_matAluno')->textarea(['rows' => 6]) ?>

                        <?= $form->field($model, 'plan_codcolaborador')->textInput() ?>

                        <?= $form->field($model, 'plan_data')->textInput() ?>

                        <?= $form->field($model, 'plan_status')->textInput() ?>

                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? 'Criar Plano' : 'Atualizar Plano', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

           </div>

