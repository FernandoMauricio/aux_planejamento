<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\solicitacoes\MaterialCopias */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="material-copias-form">

    <?php $form = ActiveForm::begin(); ?>

<div class="row">

    <div class="col-md-6">

    <?= $form->field($model, 'matc_descricao')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="col-md-2">

    <?= $form->field($model, 'matc_qtoriginais')->textInput() ?>

    </div>

    <div class="col-md-2">

    <?= $form->field($model, 'matc_qtexemplares')->textInput() ?>

    </div>

    <div class="col-md-1">

    <?= $form->field($model, 'matc_mono')->textInput() ?>

    </div>

    <div class="col-md-1">

    <?= $form->field($model, 'matc_color')->textInput() ?>

    </div>
 
    <div class="col-md-8">

    <?= $form->field($model, 'matc_curso')->textInput(['maxlength' => true]) ?>

    </div>

    <div class="col-md-4">

    <?= $form->field($model, 'matc_centrocusto')->textInput(['maxlength' => true]) ?>

    </div>
</div>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
