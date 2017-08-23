<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = 'Relatórios PAAR - Excel';
$this->params['breadcrumbs'][] = 'Relatórios';
$this->params['breadcrumbs'][] = $this->title;
?>

<h3>Relatório PAAR: <?= Html::a('Gerar Excel', ['excel-paar'], ['class' => 'btn btn-primary']) ?></h3>
