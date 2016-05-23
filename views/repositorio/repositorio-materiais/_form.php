<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\money\MaskMoney;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\repositorio\Repositorio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="repositorio-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<div class="row">

    <div class="col-md-10">

    <?= $form->field($model, 'rep_titulo')->textInput(['maxlength' => true]) ?>

    </div>


    <div class="col-md-2">

    <?php echo $form->field($model, 'rep_valor')->widget(MaskMoney::classname());  ?>

    </div>

    <div class="col-md-4">
        <?php
            $data_categoria = ArrayHelper::map($categoria, 'cat_descricao', 'cat_descricao');
            echo $form->field($model, 'rep_categoria')->widget(Select2::classname(), [
                    'data' =>  $data_categoria,
                    'options' => ['placeholder' => 'Selecione a categoria...'],
                    'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
        ?>
    </div>

    <div class="col-md-4">
        <?php
            $data_editora = ArrayHelper::map($editora, 'edi_descricao', 'edi_descricao');
            echo $form->field($model, 'rep_editora')->widget(Select2::classname(), [
                    'data' =>  $data_editora,
                    'options' => ['placeholder' => 'Selecione a editora...'],
                    'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
        ?>
    </div>

    <div class="col-md-4">
        <?php
            $data_tipo = ArrayHelper::map($tipomaterial, 'tip_descricao', 'tip_descricao');
            echo $form->field($model, 'rep_tipo')->widget(Select2::classname(), [
                    'data' =>  $data_tipo,
                    'options' => ['placeholder' => 'Selecione o tipo de Material...'],
                    'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]);
        ?>
    </div>
</div>

    <?= $form->field($model, 'rep_sobre')->textInput(['maxlength' => true]) ?>

    <?php
        echo '<label class="control-label">Arquivo</label>  <strong style="color: #E61238""><small>extensões permitidas: .pdf / .zip / .rar / .doc / .docx</small></strong>';
        echo FileInput::widget([
                'model' => $model,
                'attribute' => 'file',
                'options' => ['accept'=>'.pdf, .zip, .rar, .doc, .docx',
                ],
            'pluginOptions' => [
                    'showRemove'=> false,
                    'showUpload'=> false,
                    ],
        ]);
    ?><br>
        
    <?= $form->field($model, 'rep_status')->radioList(['1' => 'Ativo', '0' => 'Inativo']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


