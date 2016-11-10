<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;

use app\models\cadastros\Eixo;
use app\models\cadastros\Segmento;
use app\models\cadastros\Tipo;

/* @var $this yii\web\View */
/* @var $searchModel app\models\planos\PlanodeacaoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planilhas de Curso';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planodeacao-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Nova Planilha de Curso', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<?php Pjax::begin(); ?>    

<?php echo  GridView::widget([
            'dataProvider'=>$dataProvider,
            'filterModel'=>$searchModel,
            'pjax'=>true,
            'striped'=>true,
            'hover'=>true,
            'panel'=>['type'=>'primary', 'heading'=>'Listagem de Planilhas de Curso'],
            'columns'=>[
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=>'placu_codsegmento', 
                'width'=>'310px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return $model->segmento->seg_descricao;
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(Segmento::find()->orderBy('seg_descricao')->asArray()->all(), 'seg_codsegmento', 'seg_descricao'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Selecione o Segmento'],
                'group'=>true,  // enable grouping
                'groupHeader'=>function ($model, $key, $index, $widget) { // Closure method
                    return [
                        'mergeColumns'=>[[1, 3]], // columns to merge in summary
                        'content'=>[             // content to show in each summary cell
                            1=> $model->eixo->eix_descricao,
                        ],
                        // html attributes for group summary row
                        'options'=>['class'=>'info','style'=>'font-weight:bold;']
                    ];
                }
            ],

            [
                'attribute'=>'placu_codtipoa', 
                'width'=>'250px',
                'value'=>function ($model, $key, $index, $widget) { 
                    return $model->tipo->tip_descricao;
                },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(Tipo::find()->orderBy('tip_descricao')->asArray()->all(), 'tip_codtipoa', 'tip_descricao'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Selecione o Tipo de Ação'],
                'group'=>true,  // enable grouping
                'subGroupOf'=>1, // supplier column index is the parent group,
            ],

        'placu_codplanilha',

            [
              'attribute'=>'PlanoLabel',
              'value'=> 'plano.plan_descricao',
            ],

        'placu_codtipla',
        'placu_codprogramacao',
        'placu_codsituacao',
        
            ['class' => 'yii\grid\ActionColumn','template' => '{view} {update}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
