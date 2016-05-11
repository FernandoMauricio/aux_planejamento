<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\cadastros\Estruturafisica */

$this->title = 'Nova Estrutura Física';
$this->params['breadcrumbs'][] = ['label' => 'Cadastro de Estrutura Física', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="estruturafisica-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
