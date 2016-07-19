<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\cadastros\Centrocusto */

$this->title = 'Create Centrocusto';
$this->params['breadcrumbs'][] = ['label' => 'Centrocustos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="centrocusto-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'segmento' => $segmento,
        'tipoacao' => $tipoacao,
        'unidades' => $unidades,
        'anocentrocusto' => $anocentrocusto,
    ]) ?>

</div>
