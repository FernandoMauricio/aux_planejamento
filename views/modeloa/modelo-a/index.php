<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\widgets\Pjax;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\modeloa\ModeloASearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$session = Yii::$app->session;
$unidade = $session['sess_unidade'];

$this->title = 'Modelo A ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="modelo-a-index">

<?php
    //Pega as mensagens
    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
    }
?>

    <h1><?= Html::encode($this->title) . '<small>' .$unidade. '</small>' ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::button('Gerar Modelo A', ['value'=> Url::to('index.php?r=modeloa/modelo-a/gerar-modelo-a'), 'class' => 'btn btn-primary', 'id'=>'modalButton']) ?>
    </p>

    <?php
        Modal::begin([
            'header' => '<h4>Geração de Centro de Custo para compor Modelo A</h4>',
            'id' => 'modal',
            'size' => 'modal-lg',
            ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
    ?>

<?php echo  GridView::widget([
            'dataProvider'=>$dataProvider,
            'filterModel'=>$searchModel,
            'pjax'=>true,
            'striped'=>true,
            'hover'=>true,
            'panel'=>['type'=>'primary', 'heading'=>'Listagem Modelo A'],
            'rowOptions' =>function($model){
                if($model->moda_codsituacao == 1 ){
                        return['class'=>'success'];                        
                }else{
                        return['class'=>'danger'];
                }
            },
            'columns'=>[
            ['class' => 'yii\grid\SerialColumn'],

            'moda_codmodelo',
            'moda_centrocustoreduzido',
            'moda_nomecentrocusto',
            [
            'attribute' => 'moda_codano',
            'value' => 'anoModeloA.an_ano',
            ],
            [
            'attribute' => 'moda_codsituacao',
            'value' => 'situacaoModeloA.simoa_situacao',
            ],
            //'moda_centrocusto',
            // 'moda_codunidade',
            // 'moda_nomeunidade',
            // 'moda_codcolaborador',
            // 'moda_codusuario',
            // 'moda_nomeusuario',
            // 'moda_codentrada',
            // 'moda_codsegmento',
            // 'moda_codtipoacao',
            // 'moda_descriminacaoprojeto:ntext',
            // 'moda_identificacao',

            ['class' => 'yii\grid\ActionColumn','template' => '{imprimir-modelo-a} {update} {delete}',
            'options' => ['width' => '8%'],
            'buttons' => [

                        //IMPRIMIR
                        'imprimir-modelo-a' => function ($url, $model) {
                            return Html::a('<span class="glyphicon glyphicon-print"></span> ', $url, [
                                        'target'=>'_blank', 
                                        'data-pjax'=>"0",
                                        'title' => Yii::t('app', 'Imprimir'),
                       
                            ]);
                        },

                        //DELETAR
                                'delete' => function ($url, $model) {
                                    $session = Yii::$app->session;
                                    $array = [48, 74];
                                    return $session['sess_codusuario'] == in_array($session['sess_codusuario'], $array) ?  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                                'title' => Yii::t('app', 'Excluir Modelo A'),
                                                'data' => [
                                                                'confirm' => 'Confirma a exclusão deste item?',
                                                                'method' => 'post',
                                                            ],

                                    ]): '';
                                },

            ],
            ],
        ],
    ]); ?>

</div>
