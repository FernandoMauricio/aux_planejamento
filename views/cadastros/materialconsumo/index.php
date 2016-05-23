<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\cadastros\MaterialconsumoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Materialconsumos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materialconsumo-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Materialconsumo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'matcon_cod',
            'matcon_descricao',
            'matcon_tipo',
            'matcon_valor',
            'matcon_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
