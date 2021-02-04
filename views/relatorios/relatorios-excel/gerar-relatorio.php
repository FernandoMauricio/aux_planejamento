<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\bootstrap\Modal;
use yii\helpers\Url;


$this->title = 'Relatórios PAAR - Excel';
$this->params['breadcrumbs'][] = 'Relatórios';
$this->params['breadcrumbs'][] = $this->title;
?>

 <h4>Relatório PAAR: <?= Html::a('Gerar Excel', ['excel-paar'], ['class' => 'btn btn-primary']) ?></h4>

 <h4>Itens de Consumo por Unidade: <?= Html::button('Gerar Excel', ['value'=> Url::to('index.php?r=relatorios/relatorios-excel/gerar-relatorio-itens-consumo'), 'class' => 'btn btn-primary', 'id'=>'modalButton']) ?> </h4>

    <?php
        Modal::begin([
            'header' => '<h4>Defina o ano orçamentário:</h4>',
            'id' => 'modal',
            'size' => 'modal-lg',
            ]);

        echo "<div id='modalContent'></div>";

        Modal::end();
   ?>

 <h4>Material Didático por Unidade: <?= Html::button('Gerar Excel', ['value'=> Url::to('index.php?r=relatorios/relatorios-excel/gerar-relatorio-itens-material-didatico'), 'class' => 'btn btn-primary', 'id'=>'modalButton2']) ?> </h4>

    <?php
        Modal::begin([
            'header' => '<h4>Defina o ano orçamentário:</h4>',
            'id' => 'modal2',
            'size' => 'modal-lg',
            ]);

        echo "<div id='modalContent2'></div>";

        Modal::end();
   ?>


 <h4>Planilhas de Precificação: <?= Html::button('Gerar Excel', ['value'=> Url::to('index.php?r=relatorios/relatorios-excel/gerar-relatorio-planilhas-precificacao'), 'class' => 'btn btn-primary', 'id'=>'modalButton3']) ?> </h4>

    <?php
        Modal::begin([
            'header' => '<h4>Planilhas de Precificação:</h4>',
            'id' => 'modal3',
            'size' => 'modal-lg',
            ]);

        echo "<div id='modalContent3'></div>";

        Modal::end();
   ?>