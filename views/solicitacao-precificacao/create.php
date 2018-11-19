<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\solicitacao_precificacao\SolicitacaoPrecificacao */

$this->title = 'Create Solicitacao Precificacao';
$this->params['breadcrumbs'][] = ['label' => 'Solicitacao Precificacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitacao-precificacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
