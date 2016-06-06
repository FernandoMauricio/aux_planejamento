<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\solicitacoes\MaterialCopias */

$this->title = 'Create Material Copias';
$this->params['breadcrumbs'][] = ['label' => 'Material Copias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-copias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
