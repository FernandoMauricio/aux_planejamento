<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\solicitacao_precificacao\SolicitacaoPrecificacao */

$this->title = 'Update Solicitacao Precificacao: ' . $model->solpre_id;
$this->params['breadcrumbs'][] = ['label' => 'Solicitacao Precificacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->solpre_id, 'url' => ['view', 'id' => $model->solpre_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="solicitacao-precificacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
