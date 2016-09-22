<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\despesas\CustosunidadeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Listagem de Custos da Unidade';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="custosunidade-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Novo Custo', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cust_codcusto',
            'cust_codunidade',
            'cust_status',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
