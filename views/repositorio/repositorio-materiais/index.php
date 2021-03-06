<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\repositorio\RepositorioMateriaisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Materiais Didáticos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repositorio-index">

<?php
$session = Yii::$app->session;

//Pega as mensagens
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

?>
    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
        if($session['sess_codunidade'] == 11 ) { //ÁREA DA DEP
    ?>
            <p>
                <?= Html::a('Novo Material Didático', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
    <?php
        }
    ?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'rep_codrepositorio',
            'rep_codmxm',
            'rep_titulo',
            [
                'attribute'=>'rep_biblioteca', 
                'format'=>'html',
                'value'=> function ($data) {
                    return Html::a($data->rep_biblioteca == 'Sim' ? '<span class="label label-success">'.$data->rep_biblioteca.'</span>' : '<span class="label label-danger">'.$data->rep_biblioteca.'</span>');
                    },
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=> ['Sim' => 'Sim', 'Não' => 'Não'],
                'filterInputOptions'=>['placeholder'=>'Selecione...'],
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
            ],
            'rep_categoria',
            'rep_tipo',
            'rep_editora',
            [
                         'attribute'=>'rep_arquivo',
                         'format'=>'raw',
                         'contentOptions'=>['style'=>'max-width: 300px;'],
                         'value' => function($model, $key, $index){
                             $url = Yii::$app->request->baseUrl. '/uploads/repositorio/' . $model->rep_codrepositorio . '/' . $model->rep_arquivo_src;
                             return Html::a($model->rep_arquivo, $url, ['target'=> '_blank']); 
                         }
            ],
            [
                     'attribute' => 'image',
                     'format' => 'raw',
                     'value' => function ($model) {   
                        if ($model->rep_image_web_filename!='')
                          return '<img src="'.Yii::$app->request->baseUrl. '/uploads/repositorio/capas/'.$model->rep_image_web_filename.'" width="100px" height="auto">'; else return '<img src="'.Yii::$app->request->baseUrl. '/uploads/repositorio/capas/capa_nao_disponivel.png" width="100px" height="auto">';
                     },
            ],
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'rep_status', 
                'vAlign'=>'middle'
            ], 
                        
            ['class' => 'yii\grid\ActionColumn','template' => '{update}'],
        ],
    ]); ?>
</div>
