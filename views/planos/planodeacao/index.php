<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\planos\PlanodeacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planodeacaos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planodeacao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Planodeacao', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'plan_codplano',
            'plan_descricao',
            'plan_codeixo',
            'plan_codsegmento',
            'plan_codtipoa',
            // 'plan_codnivel',
            // 'plan_cargahoraria',
            // 'plan_sobre:ntext',
            // 'plan_prerequisito:ntext',
            // 'plan_orgcurricular:ntext',
            // 'plan_perfTecnico:ntext',
            // 'plan_matConsumo:ntext',
            // 'plan_matAluno:ntext',
            // 'plan_codcolaborador',
            // 'plan_data',
            // 'plan_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
