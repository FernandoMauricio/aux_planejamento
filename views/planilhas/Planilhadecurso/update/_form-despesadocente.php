<?php

use yii\helpers\Html;
use kartik\builder\Form;
use kartik\builder\FormGrid;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\despesas\Markup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="planilhadecurso-form">

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

        'planides_descricao'=>[
            'type'=>TabularForm::INPUT_STATIC, 
            'columnOptions'=>['width'=>'185px']
        ],

        'planides_descricao' => [
            'type'=>TabularForm::INPUT_STATIC,
            'format'=>['decimal',2],
            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT, 'width'=>'90px'],
        ],

        'planides_valor' => [
            'type'=>TabularForm::INPUT_STATIC,
            'format'=>['decimal',2],
            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT, 'width'=>'90px'],
        ],

        'planides_dsr' => [
            'type'=>TabularForm::INPUT_STATIC,
            'format'=>['decimal',2],
            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT, 'width'=>'90px']
        ],

        'planides_planejamento' => [
            'type'=>TabularForm::INPUT_STATIC,
            'format'=>['decimal',2],
            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT, 'width'=>'90px'],
        ],

        'planides_produtividade' => [
            'type'=>TabularForm::INPUT_STATIC,
            'format'=>['decimal',2],
            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT, 'width'=>'90px']
        ],

        'planides_valorhoraaula' => [
            'type'=>TabularForm::INPUT_STATIC,
            'format'=>['decimal',2],
            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT, 'width'=>'90px']
        ],

    ],
'gridSettings'=>[
        'floatHeader'=>true,
        'panel'=>[
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem de Docentes</h3>',
            'type' => GridView::TYPE_PRIMARY,
            'after'=> Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Atualizar Dados', ['class'=>'btn btn-primary'])
        ]
    ]   
]);
ActiveForm::end();

?>
</div>