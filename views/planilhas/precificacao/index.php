<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\planilhas\PrecificacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Precificacaos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="precificacao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Precificacao', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'planp_id',
            'planp_codunidade',
            'planp_planodeacao',
            'planp_cargahoraria',
            'planp_qntaluno',
            // 'planp_totalhorasdocente',
            // 'planp_docente',
            // 'planp_valorhoraaula',
            // 'planp_servpedagogico',
            // 'planp_horaaulaplanejamento',
            // 'planp_totalcustodocente',
            // 'planp_decimo',
            // 'planp_ferias',
            // 'planp_tercoferias',
            // 'planp_totalsalario',
            // 'planp_encargos',
            // 'planp_totalencargos',
            // 'planp_totalsalarioencargo',
            // 'planp_custosmateriais',
            // 'planp_diarias',
            // 'planp_passagens',
            // 'planp_pessoafisica',
            // 'planp_pessoajuridica',
            // 'planp_totalcustodireto',
            // 'planp_totalhoraaulacustodireto',
            // 'planp_custosindiretos',
            // 'planp_ipca',
            // 'planp_reservatecnica',
            // 'planp_despesadm',
            // 'planp_totalincidencias',
            // 'planp_totalcustoindireto',
            // 'planp_despesatotal',
            // 'planp_markdivisor',
            // 'planp_markmultiplicador',
            // 'planp_vendaturma',
            // 'planp_vendaaluno',
            // 'planp_horaaulaaluno',
            // 'planp_retorno',
            // 'planp_porcentretorno',
            // 'planp_precosugerido',
            // 'planp_retornoprecosugerido',
            // 'planp_minimoaluno',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
