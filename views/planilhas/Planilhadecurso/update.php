<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Planilhadecurso */

$this->title = 'Atualizar Planilha de Curso: ' . $model->placu_codplanilha;
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Planilhas de Curso', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->placu_codplanilha, 'url' => ['view', 'id' => $model->placu_codplanilha]];
$this->params['breadcrumbs'][] = 'Atualizar';
?>
<div class="planilhadecurso-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('update/_form', [
        'model' => $model,
        'modelsPlaniMaterial'  => $modelsPlaniMaterial,
    ]) ?>

</div>
