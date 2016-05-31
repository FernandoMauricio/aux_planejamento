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
                   
     <div class="panel panel-primary">
                      <div class="panel-heading">
                        <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span>  Cadastros de Planos de Ação</h3>
                      </div>
                            <div class="panel-body">
                                        <?php echo $form->errorSummary($model); ?>
                                 <div id="rootwizard" class="tabbable tabs-left">
                                  <ul>
                                         <li><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-file"></span> Informações</a></li>
                                         <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Material Didático</a></li>
                                         <li><a href="#tab3" data-toggle="tab"><span class="glyphicon glyphicon-tags"></span> Material de Consumo</a></li>
                                         <li><a href="#tab4" data-toggle="tab"><span class="glyphicon glyphicon-education"></span> Material do Aluno</a></li>
                                         <li><a href="#tab5" data-toggle="tab"><span class="glyphicon glyphicon-list"></span> Estrutura Física</a></li>
                                         <li><a href="#tab6" data-toggle="tab"><span class="glyphicon glyphicon-file"></span> Outros Custos</a></li>
                                  </ul>

                                              <div class="tab-content">

                                                    <div class="tab-pane" id="tab1">
                                                        <?= $this->render('_form-plano', [
                                                            'model' => $model,
                                                        ]) ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab2">
                                                        <?= $this->render('_form-planomaterial', [
                                                            'form' => $form,
                                                            'repositorio' => $repositorio,
                                                            'modelsPlanoMaterial' => $modelsPlanoMaterial,
                                                        ]) ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab3">
                                                        <?= $this->render('_form-planoconsumo', [
                                                            'form' => $form,
                                                            'materialconsumo' => $materialconsumo,
                                                            'modelsPlanoConsumo' => $modelsPlanoConsumo,
                                                        ]) ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab4">
                                                        <?= $this->render('_form-planoaluno', [
                                                            'form' => $form,
                                                            'materialaluno' => $materialaluno,
                                                            'modelsPlanoAluno' => $modelsPlanoAluno,
                                                        ]) ?>
                                                    </div>

                                                    <div class="tab-pane" id="tab5">
                                                       <?= $this->render('_form-planoestrutura', [
                                                           'form' => $form,
                                                           'estruturafisica' => $estruturafisica,
                                                           'modelsPlanoEstrutura' => $modelsPlanoEstrutura,
                                                           //'dataProviderPlanoMaterial' => $dataProviderPlanoMaterial,
                                                       ]) ?>
                                                    </div>
                                           </div> 
                                   </div> 
                            </div>
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

<?php
 $this->registerJsFile(Yii::$app->request->baseUrl.'/js/jquery.bootstrap.wizard.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
