<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\planilhas\PlanilhadecursoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planilhadecursos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planilhadecurso-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Planilhadecurso', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'placu_codplanilha',
            'placu_codeixo',
            'placu_codsegmento',
            'placu_codplano',
            'placu_codtipoa',
            // 'placu_codnivel',
            // 'placu_codsegtip',
            // 'placu_cargahorariaplano',
            // 'placu_cargahorariarealizada',
            // 'placu_cargahorariaarealizar',
            // 'placu_codano',
            // 'placu_codfinalidade',
            // 'placu_codcategoria',
            // 'placu_codtipla',
            // 'placu_quantidadeturmas',
            // 'placu_quantidadealunos',
            // 'placu_quantidadeparcelas',
            // 'placu_valormensalidade',
            // 'placu_codsituacao',
            // 'placu_codcolaborador',
            // 'placu_codunidade',
            // 'placu_nomeunidade',
            // 'placu_quantidadealunospsg',
            // 'placu_tipocalculo',
            // 'placu_arquivolistamaterial',
            // 'placu_listamaterialdoaluno',
            // 'placu_observacao:ntext',
            // 'placu_taxaretorno',
            // 'placu_cargahorariavivencia',
            // 'placu_quantidadealunosisentos',
            // 'planilhadecurso_placucol',
            // 'placu_codprogramacao',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
