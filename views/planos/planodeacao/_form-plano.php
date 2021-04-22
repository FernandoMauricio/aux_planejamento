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
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10"><?= $form->field($model, 'plan_descricao')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-2"><?= $form->field($model, 'plan_interativa')->radioList(['Sim' => 'Sim', 'Não' => 'Não']) ?></div>
                    </div>

                    <div class="row">
                        <div class="col-md-2"><?= $form->field($model, 'plan_qntaluno')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-2"><?= $form->field($model, 'plan_cargahoraria')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-2"><?= $form->field($model, 'plan_codnacional')->textInput(['maxlength' => true]) ?></div>

                        <div class="col-md-3"><?= $form->field($model, 'plan_status')->radioList([1 => 'Liberado', 0 => 'Em elaboração']) ?></div>

                        <div class="col-md-3"><?php
                            echo  $form->field($model, 'plan_modelonacional')->widget(Select2::classname(), [
                                     'data' =>  [
                                        'Não Alinhado com Modelo Pedagógico' => 'Não Alinhado com Modelo Pedagógico',
                                        'Plano de Curso Nacional' => 'Plano de Curso Nacional',
                                        'Plano de Curso de Referência (Itinerários Formativos)' => 'Plano de Curso de Referência (Itinerários Formativos)',
                                        'Plano de Curso MPS, Regional ou Núcleo' => 'Plano de Curso MPS, Regional ou Núcleo'],
                                     'options' => ['placeholder' => 'Selecione...'],
                                     'pluginOptions' => [
                                             'allowClear' => true
                                         ],
                                     ]);
                            ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <?php
                                $nivelList=ArrayHelper::map(app\models\cadastros\Nivel::find()->all(), 'niv_codnivel', 'niv_descricao' ); 
                            if ($model->isNewRecord) {
                                       echo  $form->field($model, 'plan_codnivel')->widget(Select2::classname(), [
                                                'data' =>  $nivelList,
                                                'options' => ['placeholder' => 'Selecione o Nivel...'],
                                                'pluginOptions' => [
                                                        'allowClear' => true
                                                    ],
                                                ]);
                           }else{
                                     echo $form->field($model, 'nivelLabel')->textInput(['value' => $model->nivel->niv_descricao, 'readonly' => true]);
                                }
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
                            <?= $form->field($model, 'plan_codsegmento')->widget(DepDrop::classname(), [ // Child # 1
                                    'data' => [$model->segmento->seg_descricao],
                                    'options'=>['id'=>'segmento-id'],
                                    'type'=>DepDrop::TYPE_SELECT2,
                                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                    'pluginOptions'=>[
                                        'depends'=>['eixo-id'],
                                        'placeholder'=>'Selecione o Segmento...',
                                        'url'=>yii\helpers\Url::to(['/planos/planodeacao/segmento'])
                                    ]
                                ]);  
                            ?>
                        </div>

                        <div class="col-md-3">
                            <?= $form->field($model, 'plan_codtipoa')->widget(DepDrop::classname(), [ // Child # 2
                                    'data' => [$model->tipo->tip_descricao],
                                    'type'=>DepDrop::TYPE_SELECT2,
                                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                                    'pluginOptions'=>[
                                        'depends'=>['eixo-id','segmento-id'],
                                        'placeholder'=>'Selecione o Tipo de Ação...',
                                        'url'=>Url::to(['/planos/planodeacao/tipos'])
                                    ]
                                ]);
                            ?>
                        </div>

                    </div>

                        <?= $form->field($model, 'plan_sobre')->textarea(['rows' => 4]) ?>

                        <?= $form->field($model, 'plan_prerequisito')->textarea(['rows' => 4]) ?>

                        <?= $form->field($model, 'plan_perfConclusao')->textarea(['rows' => 4]) ?>

                        <?php   $data_nivelDocente = ArrayHelper::map($nivelDocente, 'doce_id', 'doce_descricao');
                                echo $form->field($model, 'plan_nivelDocente')->widget(Select2::classname(), [
                                        'data' =>  $data_nivelDocente,
                                        'options' => ['placeholder' => 'Selecione o Nivel do Docente...'],
                                        'pluginOptions' => [
                                                'allowClear' => true
                                            ],
                                        ]); 
                        ?>

                        <?= $form->field($model, 'plan_perfTecnico')->textarea(['rows' => 4]) ?>

                        <?php    
                            $options = \yii\helpers\ArrayHelper::map($categoria, 'idcategoria', 'descricao');
                            echo $form->field($model, 'plan_categoriasPlano')->checkboxList($options); 
                        ?>
           </div>
        </div>
