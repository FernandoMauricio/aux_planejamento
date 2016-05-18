<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\repositorio\Tipomaterial */

$this->title = 'Nova Tipomaterial';
$this->params['breadcrumbs'][] = ['label' => 'Cadastro de Tipos de Materiais', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipomaterial-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
