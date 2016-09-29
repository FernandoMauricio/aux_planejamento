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
            'type'=>TabularForm::INPUT_DROPDOWN_LIST, 
            'items'=>ArrayHelper::map(Unidade::find()->orderBy('uni_nomeabreviado')->asArray()->all(), 'uni_codunidade', 'uni_nomeabreviado'),
            'columnOptions'=>['width'=>'185px']
        ],

        'mark_custoindireto' => ['type' => TabularForm::INPUT_TEXT,
        'columnOptions'=>['width'=>'50px'],
        ],

        'mark_ipca' => ['type' => TabularForm::INPUT_TEXT,
        'columnOptions'=>['width'=>'50px'],
        ],

        'mark_reservatecnica' => ['type' => TabularForm::INPUT_TEXT,
        'columnOptions'=>['width'=>'50px'],
        ],


        'mark_despesasede' => ['type' => TabularForm::INPUT_TEXT,
        'columnOptions'=>['width'=>'50px'],
        ],

        'mark_totalincidencias' => [
            //'label'=>'Total <br> Incidências (%)',
            'type'=>TabularForm::INPUT_STATIC, 
            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT, 'width'=>'90px'],
        ],

        'mark_divisor' => [
            'type'=>TabularForm::INPUT_STATIC, 
            'columnOptions'=>['hAlign'=>GridView::ALIGN_RIGHT, 'width'=>'90px']
        ],

    ],
'gridSettings'=>[
        'floatHeader'=>true,
        'panel'=>[
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> Listagem das Unidades</h3>',
            'type' => GridView::TYPE_PRIMARY,
            'after'=> Html::submitButton('<i class="glyphicon glyphicon-floppy-disk"></i> Salvar Dados', ['class'=>'btn btn-primary'])
        ]
    ]   
]);
ActiveForm::end();

?>
</div>