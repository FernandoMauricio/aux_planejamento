<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->title = 'Relatórios';
$this->params['breadcrumbs'][] = 'Relatórios';
?>

<div class="relatorios">

  <h1><?= Html::encode($this->title) ?></h1>

<?php
    //Pega as mensagens
    foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
    echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
    }
?>

    <?php $form = ActiveForm::begin(); ?>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-4">
                <?php
                    $data_ano = ArrayHelper::map($ano, 'an_ano', 'an_ano');
                    echo $form->field($model, 'placu_codano')->widget(Select2::classname(), [
                            'data' =>  $data_ano,
                            'options' => ['placeholder' => 'Selecione o ano...'],
                            'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                ?>
				</div>

                <div class="col-md-4">
                <?php
                    $data_situacao = ArrayHelper::map($situacaoPlanilha, 'sipla_codsituacao', 'sipla_descricao');
                    echo $form->field($model, 'placu_codsituacao')->widget(Select2::classname(), [
                            'data' =>  $data_situacao,
                            'options' => ['placeholder' => 'Selecione a Situação da Planilha...'],
                            'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                ?>
				</div>

                <div class="col-md-4">
                <?php
                    $data_tipoPlanilha = ArrayHelper::map($tipoPlanilha, 'tipla_codtipla', 'tipla_descricao');
                    echo $form->field($model, 'placu_codtipla')->widget(Select2::classname(), [
                            'data' =>  $data_tipoPlanilha,
                            'options' => ['placeholder' => 'Selecione o tipo da Planilha...'],
                            'pluginOptions' => [
                                    'allowClear' => true
                                ],
                            ]);
                ?>
				</div>

			</div>

        <?= Html::a('Gerar Relatório', ['relatorio'], [
            'class' => 'btn btn-success',
            'data' => [
                'method' => 'post',
            ],
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>