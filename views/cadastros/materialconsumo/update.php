<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cadastros\Materialconsumo */

$this->title = 'Update Materialconsumo: ' . $model->matcon_cod;
$this->params['breadcrumbs'][] = ['label' => 'Materialconsumos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->matcon_cod, 'url' => ['view', 'id' => $model->matcon_cod]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="materialconsumo-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
