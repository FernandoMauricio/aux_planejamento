<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Precificacao */

$this->title = $model->planp_id;
$this->params['breadcrumbs'][] = ['label' => 'Precificacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="precificacao-view">

    <h1><?= Html::encode($this->title) ?></h1>


  <div class="panel panel-primary">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> DETALHES DA PRECIFICAÇÃO DE CUSTO</h3>
    </div>
      <div class="panel-body">

          <div id="rootwizard" class="tabbable tabs-left">
           <ul>
                  <li><a href="#tab1" data-toggle="tab"><span class="glyphicon glyphicon-file"></span> Preço Ofertado</a></li>
                  <li><a href="#tab2" data-toggle="tab"><span class="glyphicon glyphicon-list"></span> Preço de Venda por Unidade</a></li>
           </ul>

            

            <div class="tab-content"><br>

                <div class="tab-pane" id="tab1">
                    <?= $this->render('view-precificacao', [
                        'model' => $model,
                    ]) ?>
                </div>

                <div class="tab-pane" id="tab2">
                    <?= $this->render('view-unidades', [
                        'model' => $model,
                    ]) ?>
                </div>

            </div>

          </div>
      </div>
  </div>
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