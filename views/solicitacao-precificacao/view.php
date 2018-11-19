<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\solicitacao_precificacao\SolicitacaoPrecificacao */

$this->title = $model->solpre_id;
$this->params['breadcrumbs'][] = ['label' => 'Solicitacao Precificacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitacao-precificacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->solpre_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->solpre_id], [
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
            'solpre_id',
            'solpre_titulo',
            'solpre_cargahoraria',
            'solpre_qntaluno',
            'solpre_observacao',
            'solpre_codplano',
            'solpre_autorizacao',
            'solpre_dataautorizacao',
            'solpre_situacao',
            'solpre_unidade',
            'solpre_solicitante',
        ],
    ]) ?>

</div>
