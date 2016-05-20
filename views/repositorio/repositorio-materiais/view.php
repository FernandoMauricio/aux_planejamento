<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\repositorio\Repositorio */

$this->title = $model->rep_codrepositorio;
$this->params['breadcrumbs'][] = ['label' => 'Repositorios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repositorio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->rep_codrepositorio], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->rep_codrepositorio], [
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
            'rep_codrepositorio',
            'rep_titulo',
            'rep_categoria',
            'rep_tipo',
            'rep_editora',
            'rep_valor',
            'rep_sobre',
            'rep_arquivo',
            'rep_codunidade',
            'rep_codcolaborador',
            'rep_data',
        ],
    ]) ?>

</div>
