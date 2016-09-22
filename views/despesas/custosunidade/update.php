<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\despesas\Custosunidade */

$this->title = 'Update Custosunidade: ' . $model->cust_codcusto;
$this->params['breadcrumbs'][] = ['label' => 'Custosunidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->cust_codcusto, 'url' => ['view', 'id' => $model->cust_codcusto]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="custosunidade-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
