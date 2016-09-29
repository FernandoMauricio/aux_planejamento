<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\despesas\CustosunidadeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listagem de Custos da Unidade';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custosunidade-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo Custo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php

    $gridColumns = [
                            [
                                'class'=>'kartik\grid\ExpandRowColumn',
                                'width'=>'50px',
                                'value'=>function ($model, $key, $index, $column) {
                                    return GridView::ROW_COLLAPSED;
                                },
                                'detail'=>function ($model, $key, $index, $column) {
                                    return Yii::$app->controller->renderPartial('/despesas/custosunidade/view_expand', ['model'=>$model]);
                                },
                                'headerOptions'=>['class'=>'kartik-sheet-style'],
                                'expandOneOnly'=>true,
                            ],

                            [
                              'attribute'=>'cust_codcusto',
                              'width'=>'5%'
                            ],

                            [
                              'attribute'=>'cust_ano',
                              'value'=> 'ano.an_ano',
                              'width'=>'10%'
                            ],

                            [
                              'attribute'=>'cust_codunidade',
                              'value'=> 'unidade.uni_nomeabreviado',
                            ],

                            [
                                'attribute'=>'cust_MediaPorcentagem', 
                                'hAlign'=>'right', 
                                'vAlign'=>'middle',
                                'width'=>'10%',
                                'format'=>['decimal', 2],
                                'pageSummary'=>true
                            ],

                            [
                                'attribute'=>'cust_MediaCustoIndireto', 
                                'hAlign'=>'right', 
                                'vAlign'=>'middle',
                                'width'=>'10%',
                                'format'=>['decimal', 2],
                                'pageSummary'=>true
                            ],

                            [
                                'class'=>'kartik\grid\BooleanColumn',
                                'attribute'=>'cust_status', 
                                'vAlign'=>'middle'
                            ], 

                            ['class' => 'yii\grid\ActionColumn','template' => '{view} {update}'],
                    ];
     ?>


    <?php Pjax::begin(['id'=>'w0-pjax']); ?>

    <?php 

    echo GridView::widget([
    'dataProvider'=>$dataProvider,
    'filterModel'=>$searchModel,
    'columns'=>$gridColumns,
    'containerOptions'=>['style'=>'overflow: auto'], // only set when $responsive = false
    'headerRowOptions'=>['class'=>'kartik-sheet-style'],
    'filterRowOptions'=>['class'=>'kartik-sheet-style'],
    'pjax'=>true, // pjax is set to always true for this demo
    'condensed' => true,
    'hover' => true,
    'beforeHeader'=>[
        [
            'columns'=>[
                ['content'=>'Detalhes de Custos da Unidade', 'options'=>['colspan'=>7, 'class'=>'text-center warning']], 
                ['content'=>'Ações', 'options'=>['colspan'=>1, 'class'=>'text-center warning']], 
            ],
        ]
    ],

        'panel' => [
        'type'=>GridView::TYPE_PRIMARY,
        'heading'=> '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem de Custos da Unidade </h3>',
    ],
]);
    ?>
    <?php Pjax::end(); ?>

</div>