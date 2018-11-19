<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\solicitacao_precificacao\SolicitacaoPrecificacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listagem de Solicitações para Precificação';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="solicitacao-precificacao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nova Solicitação', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'solpre_id',
            'solpre_titulo',
            'solpre_cargahoraria',
            'solpre_qntaluno',
            'solpre_observacao',
            // 'solpre_codplano',
            // 'solpre_autorizacao',
            // 'solpre_dataautorizacao',
            // 'solpre_situacao',
            // 'solpre_unidade',
            // 'solpre_solicitante',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
