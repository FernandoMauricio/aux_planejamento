<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

?>

<div class="relatorios">

  <h1><?= Html::encode($this->title) ?></h1>

<?php
    //Pega as mensagens
    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
    }
?>

    <?php $form = ActiveForm::begin(['options'=>['target'=>'_blank']]); ?>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-3">
                       <?= $form->field($model, 'relat_codano')->hiddenInput() ?>
      
				</div>
			</div>

        <?= Html::a('Gerar Relatório', ['gerar-relatorio-planilhas-precificacao'], [
            'class' => 'btn btn-success',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>