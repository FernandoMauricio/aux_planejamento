<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model app\models\planos\Planodeacao */
/* @var $form yii\widgets\ActiveForm */

$js = '
jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_wrapper .panel-title-planoestrutura").each(function(index) {
        jQuery(this).html("Item: " + (index + 1))
    });
});

jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
    jQuery(".dynamicform_wrapper .panel-title-planoestrutura").each(function(index) {
        jQuery(this).html("Item: " + (index + 1))
    });
});
';

$this->registerJs($js);
?>

<div class="planodeacao-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <div class="panel panel-info">
        <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Listagem de Estruturas Físicas</h4></div>
                                    <div class="panel-body">
                                         <?php DynamicFormWidget::begin([
                                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                            'widgetBody' => '.container-items', // required: css class selector
                                            'widgetItem' => '.item', // required: css class
                                            'limit' => 4, // the maximum times, an element can be cloned (default 999)
                                            'min' => 1, // 0 or 1 (default 1)
                                            'insertButton' => '.add-item', // css class
                                            'deleteButton' => '.remove-item', // css class
                                            'model' => $modelsPlanoEstrutura[0],
                                            'formId' => 'dynamic-form',
                                            'formFields' => [
                                                'planestr_cod',
                                                'planodeacao_cod',
                                                'estruturafisica_cod',
                                                'quantidade',
                                                'tipo',
                                            ],
                                        ]); ?>



                                        <div class="container-items"><!-- widgetContainer -->
                                        <?php foreach ($modelsPlanoEstrutura as $index => $modelPlanoEstrutura): ?>
                                            <div class="item panel panel-info"><!-- widgetBody -->
                                                <div class="panel-heading">
                                                <span class="panel-title-planoestrutura">Item: <?= ($index + 1) ?></span>
                                                    <div class="pull-right">
                                                        <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i></button>
                                                        <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="panel-body">
                                                
                                                    <?php
                                                        // necessary for update action.
                                                        if (! $modelPlanoEstrutura->isNewRecord) {
                                                            echo Html::activeHiddenInput($modelPlanoEstrutura, "[{$index}]planestr_cod");
                                                        }
                                                    ?>

                                                    <div class="row">
                                                        <div class="col-sm-8">
                                                                <?php

                                                                            $data_estruturafisica = ArrayHelper::map($estruturafisica, 'estr_cod', 'estr_descricao');
                                                                            echo $form->field($modelPlanoEstrutura, "[{$index}]estruturafisica_cod")->widget(Select2::classname(), [
                                                                                    'data' =>  $data_estruturafisica,
                                                                                    'options' => ['placeholder' => 'Selecione o item...'],
                                                                                    'pluginOptions' => [
                                                                                            'allowClear' => true
                                                                                        ],
                                                                                    ]);
                                                                ?>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <?= $form->field($modelPlanoEstrutura, "[{$index}]quantidade")->textInput() ?>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <?= $form->field($modelPlanoEstrutura, "[{$index}]tipo")->textInput() ?>
                                                        </div>
                                                    </div><!-- .row -->
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                        </div>
                                        <?php DynamicFormWidget::end(); ?>
                                    </div>
                                    </div>



    <?= $form->field($model, 'plan_descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_codeixo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_codsegmento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_codtipoa')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_codnivel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_cargahoraria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_sobre')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_prerequisito')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_orgcurricular')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_perfTecnico')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_matConsumo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_matAluno')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'plan_data')->textInput() ?>

    <?= $form->field($model, 'plan_status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
