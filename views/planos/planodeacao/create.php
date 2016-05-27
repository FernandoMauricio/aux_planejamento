<?php

use yii\helpers\Html;



/* @var $this yii\web\View */
/* @var $model app\models\planos\Planodeacao */

$this->title = 'Novo Plano de Ação';
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Planos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planodeacao-create">

	<?php
	    echo $this->render('_form', [
	            'model' => $model,
	            'estruturafisica' => $estruturafisica,
	            'repositorio' => $repositorio,
	            'materialconsumo' => $materialconsumo,
	            'materialaluno' => $materialaluno,
	            'modelsPlanoMaterial' => (empty($modelsPlanoMaterial)) ? [new PlanoMaterial] : $modelsPlanoMaterial,
	            'modelsPlanoEstrutura' => (empty($modelsPlanoEstrutura)) ? [new PlanoEstruturafisica] : $modelsPlanoEstrutura,
	            'modelsPlanoConsumo' => (empty($modelsPlanoConsumo)) ? [new PlanoConsumo] : $modelsPlanoConsumo,
	            'modelsPlanoAluno' => (empty($modelsPlanoAluno)) ? [new PlanoAluno] : $modelsPlanoAluno,
	    ])
	?>

</div>