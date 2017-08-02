<?php

use yii\helpers\Html;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\base\Unidade;


/* @var $this yii\web\View */
/* @var $model app\models\despesas\Markup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="markup-form">

<?php

//Pega as mensagens
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

?>
    <?php $form = ActiveForm::begin(); ?>

<?php

echo TabularForm::widget([
    'form' => $form,
    'dataProvider' => $dataProvider,
    'checkboxColumn' =>false,
    'actionColumn' =>false,
    'attributes' => [

        'mark_codunidade'=>[
            'type'=>TabularForm::INPUT_STATIC, 
            'value' => function($model, $key, $index, $widget) {
                return $model->unidade->uni_nomeabreviado;
                },
            'columnOptions'=>['width'=>'185px']
        ],

        'mark_custoindireto' => ['type' => TabularForm::INPUT_TEXT,
        'columnOptions'=>['hAlign'=>GridView::ALIGN_CENTER,'width'=>'50px'],
        'format'=>['decimal',2],
        'type' => function($model, $key, $index, $widget) {
                return ($model->mark_ano != date('Y')) ? TabularForm::INPUT_HIDDEN : TabularForm::INPUT_STATIC; //Caso os custos da unidade unidade não estiverem atualizados para o ano corrent, não aparecerá o Custo Indireto
                },
        ],

        'mark_ipca' => [
        'type' => function($model, $key, $index, $widget) { return ($model->mark_tipo == 1) ? TabularForm::INPUT_TEXT : TabularForm::INPUT_STATIC; },
        'columnOptions'=>['width'=>'50px'],
        ],

        'mark_reservatecnica' => [
        'type' => function($model, $key, $index, $widget) { return ($model->mark_tipo == 1) ? TabularForm::INPUT_TEXT : TabularForm::INPUT_STATIC; },
        'columnOptions'=>['width'=>'50px'],
        ],

        'mark_despesasede' => [
        'type' => function($model, $key, $index, $widget) { return ($model->mark_tipo == 1) ? TabularForm::INPUT_TEXT : TabularForm::INPUT_STATIC; },
        'columnOptions'=>['width'=>'50px'],
        ],

        'mark_totalincidencias' => [
            'type'=>TabularForm::INPUT_STATIC,
            'format'=>['decimal',2],
            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT, 'width'=>'90px'],
        ],

        'mark_divisor' => [
            'type'=>TabularForm::INPUT_STATIC,
            'format'=>['decimal',2],
            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT, 'width'=>'90px']
        ],

    ],
'gridSettings'=>[
        'floatHeader'=>true,
        'rowOptions' => function($model, $key, $index, $widget) { return ($model->mark_tipo == 1) ? ['class' => GridView::TYPE_DEFAULT] : ['class' => GridView::TYPE_WARNING]; },
        'panel'=>[
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem das Unidades</h3>',
            'type' => GridView::TYPE_PRIMARY,
            'after'=> Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Atualizar Dados', ['class'=>'btn btn-primary'])
        ]
    ]   
]);
ActiveForm::end();

?>
</div>