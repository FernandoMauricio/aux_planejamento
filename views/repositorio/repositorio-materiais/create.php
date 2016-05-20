<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\repositorio\Repositorio */

$this->title = 'Create Repositorio';
$this->params['breadcrumbs'][] = ['label' => 'Repositorios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="repositorio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
