<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\cadastros\Materialconsumo */

$this->title = 'Create Materialconsumo';
$this->params['breadcrumbs'][] = ['label' => 'Materialconsumos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materialconsumo-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
