<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Planilhadecurso */

$this->title = 'Create Planilhadecurso';
$this->params['breadcrumbs'][] = ['label' => 'Planilhadecursos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planilhadecurso-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
