<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Precificacao */

$this->title = 'Atualizar Planilha de  Precificação: ' . $model->planp_id;
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Precificação de Custo', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->planp_id, 'url' => ['view', 'id' => $model->planp_id]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="precificacao-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    	<?= Html::a('<i class="glyphicon glyphicon-refresh"></i> Recalcular Planilha', ['recalcular-planilha', 'id' => $model->planp_id], [
            'class' => 'btn btn-success',
            'data' =>[
                'confirm' => 'Você tem <b>certeza</b> que deseja <b>recalcular</b> a planilha?',
                'method' => 'post',
            ]
            ]) ?>
    </p>

    <?= $this->render('update/_form-update', [
        'model' => $model,
        'planos' => $planos,
        'unidades' => $unidades,
        'nivelDocente' => $nivelDocente,
    ]) ?>

</div>
