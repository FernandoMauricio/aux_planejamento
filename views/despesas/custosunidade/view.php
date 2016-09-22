<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\despesas\Custosunidade */

$this->title = $model->cust_codcusto;
$this->params['breadcrumbs'][] = ['label' => 'Custosunidades', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custosunidade-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->cust_codcusto], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->cust_codcusto], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cust_codcusto',
            'cust_codunidade',
            'cust_status',
        ],
    ]) ?>

</div>
