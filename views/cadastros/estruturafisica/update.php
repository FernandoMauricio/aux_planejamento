<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\cadastros\Estruturafisica */

$this->title = 'Atualizar Estrutura Física: ' . $model->estr_cod;
$this->params['breadcrumbs'][] = ['label' => 'Cadastro de Estrutura Física', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->estr_cod];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="estruturafisica-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
