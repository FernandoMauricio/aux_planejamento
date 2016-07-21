<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel app\models\cadastros\CentrocustoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listagem de Centros de Custo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="centrocusto-index">

<?php

//Pega as mensagens
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'cen_codcentrocusto',
            'cen_codano',
            [
                'attribute' => 'cen_codunidade',
                'value' => 'unidade.uni_nomeabreviado'
            ],
            'cen_centrocusto',
            'cen_centrocustoreduzido',
            'cen_nomecentrocusto',
            [
                'attribute' => 'cen_codsegmento',
                'value' => 'segmento.seg_descricao',
            ],
            [
                'attribute' => 'cen_codtipoacao',
                'value' => 'tipoacao.tip_descricao',
            ],

            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'cen_codsituacao', 
                'vAlign'=>'middle'
            ], 

            ['class' => 'yii\grid\ActionColumn','template' => '{update}'],
        ],
    ]); ?>
</div>
