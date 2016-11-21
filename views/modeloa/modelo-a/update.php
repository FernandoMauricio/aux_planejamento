<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\modeloa\ModeloA */

$this->title = 'Update Modelo A: ' . $model->moda_codmodelo;
$this->params['breadcrumbs'][] = ['label' => 'Modelo As', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->moda_codmodelo, 'url' => ['view', 'id' => $model->moda_codmodelo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="modelo-a-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetalhesModeloA'  => $modelsDetalhesModeloA,
    ]) ?>

</div>
