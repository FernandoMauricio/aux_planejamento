<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\repositorio\Repositorio */

$this->title = 'Update Repositorio: ' . $model->rep_codrepositorio;
$this->params['breadcrumbs'][] = ['label' => 'Repositorios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->rep_codrepositorio, 'url' => ['view', 'id' => $model->rep_codrepositorio]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="repositorio-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
