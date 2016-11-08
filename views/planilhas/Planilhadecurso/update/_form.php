<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Json;

use app\models\cadastros\Ano;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Tipoprogramacao;
use app\models\planilhas\Planilhamaterial;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Planilhadecurso */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planilhadecurso-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

        <div class="panel panel-primary">
                      <div class="panel-heading">
                       <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Nova Planilha de Curso</h3>
                      </div>
                            <div class="panel-body">
                                        <?php echo $form->errorSummary($model); ?>
                                <div id="rootwizard" class="tabbable tabs-left">
                                  <ul>
                                         <li><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-file"></span> Planilha de Curso</a></li>
                                         <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-folder-open"></span> Despesas Diretas</a></li>
                                         <li><a href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Organização Curricular</a></li>
                                         <li><a href="#tab4" data-toggle="tab"><span class="glyphicon glyphicon-tags"></span> Materiais Didáticos </a></li>
                                         <li><a href="#tab5" data-toggle="tab"><span class="glyphicon glyphicon-education"></span> Material de Consumo </a></li>
                                         <li><a href="#tab6" data-toggle="tab"><span class="glyphicon glyphicon-list"></span> Equipamentos / Utensílios</a></li>
                                  </ul>

                                            <div class="tab-content"><br>

                                                    <div class="tab-pane" id="tab1">
                                                        <?= $this->render('_form-planilha', [
                                                            'form' => $form,
                                                            'model' => $model,
                                                        ]) ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab2">
                                                        <?= $this->render('_form-despesasdiretas', [
                                                            'form' => $form,
                                                            'model' => $model,
                                                        ]) ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab3">
                                                        <?= $this->render('_form-orgcurricular', [
                                                            'form' => $form,
                                                            'model' => $model,
                                                            'modelsPlaniMaterial'  => $modelsPlaniMaterial,
                                                        ]) ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab4">
                                                        <?= $this->render('_form-materiaisdidaticos', [
                                                            'form' => $form,
                                                            'model' => $model,
                                                        ]) ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab5">
                                                        <?= $this->render('_form-materiaisconsumo', [
                                                            'form' => $form,
                                                            'model' => $model,
                                                        ]) ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab6">
                                                        <?= $this->render('_form-equipamentos', [
                                                            'form' => $form,
                                                            'model' => $model,
                                                        ]) ?>
                                                    </div>


                                                       <!-- SUBMIT CRIAÇÃO DO PLANO -->
                                                        <div class="form-group">
                                                        <?= Html::submitButton($model->isNewRecord ? 'Criar Plano' : 'Atualizar Plano', ['class' => $model->isNewRecord ?'btn btn-success btn-lg btn-block' : 'btn btn-primary btn-lg btn-block']) ?>
                                                        </div>
                                             </div>
                                </div> 
                        </div> 
         </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

            <!--          JS etapas dos formularios            -->
<?php
$script = <<< JS
$(document).ready(function() {
    $('#rootwizard').bootstrapWizard({'tabClass': 'nav nav-tabs'});
});

JS;
$this->registerJs($script);
?>

<?php  $this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.bootstrap.wizard.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>
