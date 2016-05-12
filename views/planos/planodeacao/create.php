<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\planos\Planodeacao */

$this->title = 'Create Planodeacao';
$this->params['breadcrumbs'][] = ['label' => 'Planodeacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planodeacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'estruturafisica' => $estruturafisica,
        'modelsPlanoEstrutura' => (empty($modelsPlanoEstrutura)) ? [new PlanoEstruturafisica] : $modelsPlanoEstrutura,
    ]) ?>

</div>
