<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

use app\models\base\Unidade;

/* @var $this yii\web\View */
/* @var $searchModel app\models\planilhas\PrecificacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

//Pega as mensagens
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

$this->title = 'Listagem de Precificação de Custo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="precificacao-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
        $session = Yii::$app->session;
        if($session['sess_codunidade'] == 51) { //ÁREA DO GPO
    ?>
            <p>
                <?= Html::a('Nova', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
    <?php
        }
    ?>

<?php
    $gridColumns = [
                    [
                        'class'=>'kartik\grid\ExpandRowColumn',
                        'width'=>'5%',
                        'value'=>function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail'=>function ($model, $key, $index, $column) {
                            return Yii::$app->controller->renderPartial('/planilhas/precificacao/view_expand', ['model'=>$model]);
                        },
                        'headerOptions'=>['class'=>'kartik-sheet-style'],
                        'expandOneOnly'=>true,
                    ],

                    [
                    'attribute'=>'planp_codunidade', 
                    'width'=>'10%',
                    'value'=>function ($model, $key, $index, $widget) { 
                        return $model->unidade->uni_nomeabreviado;
                    },
                    'filterType'=>GridView::FILTER_SELECT2,
                    'filter'=>ArrayHelper::map(Unidade::find()->where(['uni_codsituacao' => 1, 'uni_coddisp' => 1])->orderBy('uni_nomeabreviado')->asArray()->all(), 'uni_codunidade', 'uni_nomeabreviado'), 
                    'filterWidgetOptions'=>[
                        'pluginOptions'=>['allowClear'=>true],
                    ],
                         'filterInputOptions'=>['placeholder'=>'Selecione a Unidade'],
                         'group'=>true,  // enable grouping
                    ],

                    [
                      'attribute'=>'planp_ano',
                      'width'=>'3%',
                    ],

                    [
                      'attribute'=>'planp_id',
                      'width'=>'3%',
                    ],

                    [
                      'attribute'=>'planp_planodeacao',
                      'width'=>'3%',
                    ],

                    [
                      'attribute'=>'labelCurso',
                      'value'=> 'planodeacao.plan_descricao',
                    ],

                    [
                      'attribute'=>'planp_observacao',
                      'width'=>'3%',
                    ],

                    [
                      'attribute'=>'planp_cargahoraria',
                      'width'=>'3%',
                    ],  

                    [
                      'attribute'=>'planp_qntaluno',
                      'width'=>'3%',
                    ],    

                    [
                      'attribute'=>'planp_precosugerido',
                      //'format' => 'currency',
                      'width'=>'3%',
                    ], 

                    [
                      'label' => 'Min. Alunos',
                      'attribute'=>'planp_minimoaluno',
                      'width'=>'3%',
                    ], 

                     ['class' => 'yii\grid\ActionColumn',
                                 'template' => '{view} {update} {delete}',
                                 'contentOptions' => ['style' => 'width: 20%;'],
                                 'buttons' => [

                                 //VISUALIZAR CONTRATAÇÃO
                                 'view' => function ($url, $model) {
                                     return Html::a('<span class="glyphicon glyphicon-eye-open"></span> ', $url, [
                                                 'class'=>'btn btn-default btn-xs',
                                                 'title' => Yii::t('app', 'Visualizar'),
                                             ]);
                                 },

                                 //ATUALIZAR A SOLICITAÇÃO
                                 'update' => function ($url, $model) {
                                    $session = Yii::$app->session;
                                     return $session['sess_codunidade'] == 51 ? Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                         'class'=>'btn btn-primary btn-xs',
                                         'title' => Yii::t('app', 'Atualizar'),
                                            ]): '';
                                 },

                                 //DELETAR A SOLICITAÇÃO
                                 'delete' => function ($url, $model) {
                                    $session = Yii::$app->session;
                                     return $session['sess_codunidade'] == 51 ? Html::a('<span class="glyphicon glyphicon-trash"></span> ', $url, [
                                     'class'=>'btn btn-danger btn-xs',
                                     'title' => Yii::t('app', 'Deletar'),
                                     'data' =>  [
                                                     'confirm' => 'Você tem CERTEZA que deseja EXCLUIR esse item?',
                                                     'method' => 'post',
                                                ]
                                             ]): '';
                                 },
                              ],
                     ]
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
                ['content'=>'Detalhes da Precificação de Custo', 'options'=>['colspan'=>11, 'class'=>'text-center warning']],
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