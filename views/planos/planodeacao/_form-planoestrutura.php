<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

use wbraganca\dynamicform\DynamicFormWidget;

?>


    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>
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


        <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-list-alt"></i> Listagem de Estrutura Física
                    <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i> Adicionar Item</button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body container-items"><!-- widgetContainer -->
                    <?php foreach ($modelsPlanoEstrutura as $index => $modelPlanoEstrutura): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <span class="panel-title-planoestrutura">Item: <?= ($index + 1) ?></span>
                                <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                    // necessary for update action.
                                    if (!$modelPlanoEstrutura->isNewRecord) {
                                        echo Html::activeHiddenInput($modelPlanoEstrutura, "[{$index}]id");
                                    }
                                ?>

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
                                            <?php
                                                        $data_estruturafisica = ArrayHelper::map($estruturafisica, 'estr_cod', 'estr_descricao');
                                                        echo $form->field($modelPlanoEstrutura, "[{$index}]tipo")->widget(Select2::classname(), [
                                                                'data' =>  ['aluno'=> 'aluno', 'turma'=>'turma'],
                                                                'options' => ['placeholder' => 'Selecione o tipo...'],
                                                                'pluginOptions' => [
                                                                        'allowClear' => true
                                                                    ],
                                                                ]);
                                            ?>
                                    </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php DynamicFormWidget::end(); ?>

<?php

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