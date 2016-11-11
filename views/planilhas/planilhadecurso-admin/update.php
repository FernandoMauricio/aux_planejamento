<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\PlanilhadecursoAdmin */

$this->title = 'Update Planilhadecurso Admin: ' . $model->placu_codplanilha;
$this->params['breadcrumbs'][] = ['label' => 'Planilhadecurso Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->placu_codplanilha, 'url' => ['view', 'id' => $model->placu_codplanilha]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="planilhadecurso-admin-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
