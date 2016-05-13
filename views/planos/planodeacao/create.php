<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model app\models\planos\Planodeacao */

$this->title = 'Novo Plano de Ação';
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Planos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planodeacao-create">

  <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><span class="glyphicon glyphicon-book"></span>  Cadastros de Planos de Ação</h3>
      </div>
            <div class="panel-body">
                 <div id="rootwizard" class="tabbable tabs-left">
                 <ul>
                         <li><a href="#tab1" data-toggle="tab">Informações</a></li>
                         <li><a href="#tab2" data-toggle="tab">Material Didático</a></li>
                         <li><a href="#tab3" data-toggle="tab">Material de Consumo</a></li>
                         <li><a href="#tab4" data-toggle="tab">Material do Aluno</a></li>
                         <li><a href="#tab5" data-toggle="tab">Estrutura Física</a></li>
                         <li><a href="#tab6" data-toggle="tab">Outros Custos</a></li>
                     </ul>

                             <div class="tab-content">

                             				 <div class="tab-pane" id="tab1">

                             				    <?= $this->render('_form', [
                             				        'model' => $model,
                             				        'estruturafisica' => $estruturafisica,
                             				        'modelsPlanoEstrutura' => (empty($modelsPlanoEstrutura)) ? [new PlanoEstruturafisica] : $modelsPlanoEstrutura,
                             				    ]) ?>

                             				</div>

                         		</div> 

                   </div> 

           	</div>
 	
  </div>