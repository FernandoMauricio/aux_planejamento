<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\cadastros\MaterialconsumoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Materiais de Consumo';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materialconsumo-index">

<?php

//Pega as mensagens
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'matcon_cod',
            'matcon_descricao',
            'matcon_tipo',
            'matcon_valor',
            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'matcon_status', 
                'vAlign'=>'middle'
            ], 
                        
            ['class' => 'yii\grid\ActionColumn','template' => '{update}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
