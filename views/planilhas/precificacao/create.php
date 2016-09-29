<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Precificacao */

$this->title = 'Create Precificacao';
$this->params['breadcrumbs'][] = ['label' => 'Precificacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="precificacao-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'planos' => $planos,
        'unidades' => $unidades,
        'nivelDocente' => $nivelDocente,
    ]) ?>

</div>
