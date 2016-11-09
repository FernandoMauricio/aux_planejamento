<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Planilhadecurso */

$this->title = $model->placu_codplanilha;
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Planilhas de Curso', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planilhadecurso-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->placu_codplanilha], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->placu_codplanilha], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'placu_codplanilha',
            'placu_codeixo',
            'placu_codsegmento',
            'placu_codplano',
            'placu_codtipoa',
            'placu_codnivel',
            'placu_cargahorariaplano',
            'placu_cargahorariarealizada',
            'placu_cargahorariaarealizar',
            'placu_codano',
            'placu_codcategoria',
            'placu_codtipla',
            'placu_quantidadeturmas',
            'placu_quantidadealunos',
            'placu_quantidadeparcelas',
            'placu_valormensalidade',
            'placu_codsituacao',
            'placu_codcolaborador',
            'placu_codunidade',
            'placu_nomeunidade',
            'placu_quantidadealunospsg',
            'placu_tipocalculo',
            'placu_observacao:ntext',
            'placu_taxaretorno',
            'placu_cargahorariavivencia',
            'placu_quantidadealunosisentos',
            'placu_codprogramacao',
        ],
    ]) ?>

</div>
