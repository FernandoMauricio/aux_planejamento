<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\repositorio\Tipomaterial */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tipomaterial-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tip_descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tip_status')->radioList(['1' => 'Ativo', '0' => 'Inativo']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
