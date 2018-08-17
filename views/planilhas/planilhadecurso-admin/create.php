<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\planilhas\PlanilhadecursoAdmin */

$this->title = 'Create Planilhadecurso Admin';
$this->params['breadcrumbs'][] = ['label' => 'Planilhadecurso Admins', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planilhadecurso-admin-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
