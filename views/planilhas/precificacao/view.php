<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Precificacao */

$this->title = $model->planp_id;
$this->params['breadcrumbs'][] = ['label' => 'Precificacaos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="precificacao-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->planp_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->planp_id], [
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
            'planp_id',
            'planp_codunidade',
            'planp_planodeacao',
            'planp_cargahoraria',
            'planp_qntaluno',
            'planp_totalhorasdocente',
            'planp_docente',
            'planp_valorhoraaula',
            'planp_servpedagogico',
            'planp_horaaulaplanejamento',
            'planp_totalcustodocente',
            'planp_decimo',
            'planp_ferias',
            'planp_tercoferias',
            'planp_totalsalario',
            'planp_encargos',
            'planp_totalencargos',
            'planp_totalsalarioencargo',
            'planp_custosmateriais',
            'planp_diarias',
            'planp_passagens',
            'planp_pessoafisica',
            'planp_pessoajuridica',
            'planp_totalcustodireto',
            'planp_totalhoraaulacustodireto',
            'planp_custosindiretos',
            'planp_ipca',
            'planp_reservatecnica',
            'planp_despesadm',
            'planp_totalincidencias',
            'planp_totalcustoindireto',
            'planp_despesatotal',
            'planp_markdivisor',
            'planp_markmultiplicador',
            'planp_vendaturma',
            'planp_vendaaluno',
            'planp_horaaulaaluno',
            'planp_retorno',
            'planp_porcentretorno',
            'planp_precosugerido',
            'planp_retornoprecosugerido',
            'planp_minimoaluno',
        ],
    ]) ?>

</div>
