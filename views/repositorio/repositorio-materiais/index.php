<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\repositorio\RepositorioMateriaisSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Repositorios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repositorio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Repositorio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
