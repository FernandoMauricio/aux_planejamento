<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cadastros\Nivel */

$this->title = 'Update Nivel: ' . $model->niv_codnivel;
$this->params['breadcrumbs'][] = ['label' => 'Nivels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->niv_codnivel, 'url' => ['view', 'id' => $model->niv_codnivel]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nivel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
