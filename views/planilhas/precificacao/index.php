<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
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
<?php Pjax::begin(); ?>    <?= GridView::widget([
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
            // 'planp_diarias',
            // 'planp_passagens',
            // 'planp_pessoafisica',
            // 'planp_pessoajuridica',
            // 'planp_totalcustodireto',
            // 'planp_totalhoraaulacustodireto',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
