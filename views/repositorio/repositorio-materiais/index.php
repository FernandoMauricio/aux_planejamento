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

//Pega as mensagens
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo Material Didático', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'rep_codrepositorio',
            'rep_titulo',
            'rep_categoria',
            'rep_tipo',
            'rep_editora',
            // 'rep_valor',
            // 'rep_sobre',
            // 'rep_arquivo',
            // 'rep_codunidade',
            // 'rep_codcolaborador',
            // 'rep_data',

            [
                'class'=>'kartik\grid\BooleanColumn',
                'attribute'=>'rep_status', 
                'vAlign'=>'middle'
            ], 
                        
            ['class' => 'yii\grid\ActionColumn','template' => '{update}'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
