<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\planos\Planodeacao */

$this->title = $model->plan_codplano;
$this->params['breadcrumbs'][] = ['label' => 'Planodeacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planodeacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->plan_codplano], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->plan_codplano], [
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
            'plan_codplano',
            'plan_descricao',
            'plan_codeixo',
            'plan_codsegmento',
            'plan_codtipoa',
            'plan_codnivel',
            'plan_cargahoraria',
            'plan_sobre:ntext',
            'plan_prerequisito:ntext',
            'plan_orgcurricular:ntext',
            'plan_perfTecnico:ntext',
            'plan_matConsumo:ntext',
            'plan_matAluno:ntext',
            'plan_codcolaborador',
            'plan_data',
            'plan_status',
        ],
    ]) ?>

</div>
