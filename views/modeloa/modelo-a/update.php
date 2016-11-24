<?php

use yii\helpers\Html;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\models\modeloa\ModeloA */

$this->title = 'Atualizar Modelo A: ' . $model->moda_codmodelo;
$this->params['breadcrumbs'][] = ['label' => 'Listagem Modelo A', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->moda_codmodelo];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="modelo-a-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    <?= Html::a('<i class="glyphicon glyphicon-print"></i> Imprimir Modelo A', ['imprimir-modelo-a', 'id' => $model->moda_codmodelo], ['target'=>'_blank', 'class' => 'btn btn-info']) ?>
    </p>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsDetalhesModeloA'  => $modelsDetalhesModeloA,
        'situacaoModeloA' => $situacaoModeloA,
    ]) ?>

</div>
