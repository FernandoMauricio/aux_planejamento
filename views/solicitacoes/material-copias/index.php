<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\solicitacoes\MaterialCopiasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Material Copias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="material-copias-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Material Copias', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'matc_id',
            'matc_descricao',
            'matc_qtoriginais',
            'matc_qtexemplares',
            'matc_mono',
            // 'matc_color',
            // 'matc_curso',
            // 'matc_centrocusto',
            // 'matc_unidade',
            // 'matc_solicitante',
            // 'matc_data',
            // 'situacao_id',
            // 'matc_qteCopias',
            // 'matc_qteTotal',
            // 'matc_totalValorMono',
            // 'matc_totalValorColor',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
