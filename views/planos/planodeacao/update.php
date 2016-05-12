<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\planos\Planodeacao */

$this->title = 'Update Planodeacao: ' . $model->plan_codplano;
$this->params['breadcrumbs'][] = ['label' => 'Planodeacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->plan_codplano, 'url' => ['view', 'id' => $model->plan_codplano]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="planodeacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
