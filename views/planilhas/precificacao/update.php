<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Precificacao */

$this->title = 'Update Precificacao: ' . $model->planp_id;
$this->params['breadcrumbs'][] = ['label' => 'Precificacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->planp_id, 'url' => ['view', 'id' => $model->planp_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="precificacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>