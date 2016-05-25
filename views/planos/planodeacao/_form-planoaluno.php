<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Json;
use yii\helpers\Url;

use wbraganca\dynamicform\DynamicFormWidget;

?>


    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>
                                         <?php DynamicFormWidget::begin([
                                            'widgetContainer' => 'dynamicform_planoaluno', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                            'widgetBody' => '.container-items-planoaluno', // required: css class selector
                                            'widgetItem' => '.item-planoaluno', // required: css class
                                            'limit' => 4, // the maximum times, an element can be cloned (default 999)
                                            'min' => 1, // 0 or 1 (default 1)
                                            'insertButton' => '.add-item-planoaluno', // css class
                                            'deleteButton' => '.remove-item-planoaluno', // css class
                                            'model' => $modelsPlanoAluno[0],
                                            'formId' => 'dynamic-form',
                                            'formFields' => [
                                                'planodeacao_cod',
                                                'materialaluno_cod',
                                                'planmatalu_unidade',
                                                'planmatalu_tipo',
                                                'planmatalu_valor',
                                                'planmatalu_quantidade',
                                            ],
                                        ]); ?>


        <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-list-alt"></i> Listagem de Materiais do Aluno
                    <button type="button" class="pull-right add-item-planoaluno btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i> Adicionar Item</button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body container-items-planoaluno"><!-- widgetContainer -->
                    <?php foreach ($modelsPlanoAluno as $index => $modelPlanoAluno): ?>
                        <div class="item-planoaluno panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <span class="panel-title-planoaluno">Item: <?= ($index + 1) ?></span>
                                <button type="button" class="pull-right remove-item-planoaluno btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                    // necessary for update action.
                                    if (!$modelPlanoAluno->isNewRecord) {
                                        echo Html::activeHiddenInput($modelPlanoAluno, "[{$index}]planmatalu_cod");
                                    }
                                ?>

                                    <div class="col-sm-7">
                                    <?php
                                         $data_planoaluno = ArrayHelper::map($materialaluno, 'matalu_cod', 'matalu_descricao');
                                         echo $form->field($modelPlanoAluno, "[{$index}]materialaluno_cod")->widget(Select2::classname(), [
                                                 'data' =>  $data_planoaluno,
                                                 'options' => ['placeholder' => 'Selecione o Material do Aluno...',
                                                 'onchange'=>'
                                                         var select = this;
                                                         $.getJSON( "'.Url::toRoute('/planos/planodeacao/get-plano-aluno').'", { mataluId: $(this).val() } )
                                                         .done(function( data ) {

                                                                var $divPanelBody =  $(select).parent().parent().parent();

                                                                var $inputUnidade = $divPanelBody.find("input:eq(0)");
                                                                var $inputValor = $divPanelBody.find("input:eq(1)");

                                                                $inputUnidade.val(data.matalu_unidade);
                                                                $inputValor.val(data.matalu_valor);

                                                             });
                                                         '
                                                 ]]);
                                      ?>
                                    </div>

                                    <div class="col-sm-1">
                                        <?= $form->field($modelPlanoAluno, "[{$index}]planmatalu_unidade")->textInput(['readonly'=> true]) ?>
                                    </div>

                                    <div class="col-sm-1">
                                        <?= $form->field($modelPlanoAluno, "[{$index}]planmatalu_valor")->textInput(['readonly'=> true]) ?>
                                    </div>

                                    <div class="col-sm-1">
                                        <?= $form->field($modelPlanoAluno, "[{$index}]planmatalu_quantidade")->textInput() ?>
                                    </div>

                                    <div class="col-sm-2">
                                         <?php
                                                        echo $form->field($modelPlanoAluno, "[{$index}]planmatalu_tipo")->widget(Select2::classname(), [
                                                                'data' =>  ['PRONATEC'=>'PRONATEC', 'PSG'=>'PSG', 'PRONATEC/PSG'=>'PRONATEC/PSG','BALCÃO'=>'BALCÃO'],
                                                                'options' => ['placeholder' => 'Selecione o tipo do Material...'],
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
jQuery(".dynamicform_planoaluno").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_planoaluno .panel-title-planoaluno").each(function(index) {
        jQuery(this).html("Item: " + (index + 1))
    });
});

jQuery(".dynamicform_planoaluno").on("afterDelete", function(e) {
    jQuery(".dynamicform_planoaluno .panel-title-planoaluno").each(function(index) {
        jQuery(this).html("Item: " + (index + 1))
    });
});

';

$this->registerJs($js);



?>