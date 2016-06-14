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

                    <div class="row">
                        <div class="col-md-10">

                        <?= $form->field($model, 'plan_descricao')->textInput(['maxlength' => true]) ?>

                         </div>

                         <div class="col-md-2">

                        <?= $form->field($model, 'plan_cargahoraria')->textInput(['maxlength' => true]) ?>

                         </div>

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

                        <?= $form->field($model, 'tipoLabel')->textInput(['value'=> $model->tipo->tip_descricao,'readonly'=>true]) ?>

                        </div>

                      </div>

                        <?= $form->field($model, 'plan_sobre')->textarea(['rows' => 4]) ?>

                        <?= $form->field($model, 'plan_prerequisito')->textarea(['rows' => 4]) ?>

                        <?= $form->field($model, 'plan_orgcurricular')->textarea(['rows' => 4]) ?>

                        <?= $form->field($model, 'plan_perfConclusao')->textarea(['rows' => 4]) ?>

                        <?= $form->field($model, 'plan_perfTecnico')->textarea(['rows' => 4]) ?>

                        <?= $form->field($model, 'plan_status')->radioList(['1' => 'Ativo', '0' => 'Inativo']) ?>

                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? 'Criar Plano' : 'Atualizar Plano', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>

           </div>

