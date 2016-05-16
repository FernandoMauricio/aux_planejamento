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
	            'tipoplanomaterial' => $tipoplanomaterial,
	            'modelsPlanoMaterial' => (empty($modelsPlanoMaterial)) ? [new PlanoMaterial] : $modelsPlanoMaterial,
	            'modelsPlanoEstrutura' => (empty($modelsPlanoEstrutura)) ? [new PlanoEstruturafisica] : $modelsPlanoEstrutura,
	    ])
	?>

</div>