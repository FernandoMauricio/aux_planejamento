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
                                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                            'widgetBody' => '.container-items', // required: css class selector
                                            'widgetItem' => '.item', // required: css class
                                            'limit' => 4, // the maximum times, an element can be cloned (default 999)
                                            'min' => 1, // 0 or 1 (default 1)
                                            'insertButton' => '.add-item', // css class
                                            'deleteButton' => '.remove-item', // css class
                                            'model' => $modelsPlanoMaterial[0],
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
                    <i class="glyphicon glyphicon-list-alt"></i> Listagem de Materias Didáticos
                    <button type="button" class="pull-right add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i> Adicionar Item</button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body container-items"><!-- widgetContainer -->
                    <?php foreach ($modelsPlanoMaterial as $index => $modelPlanoMaterial): ?>
                        <div class="item panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <span class="panel-title-planoestrutura">Item: <?= ($index + 1) ?></span>
                                <button type="button" class="pull-right remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                    // necessary for update action.
                                    if (!$modelPlanoMaterial->isNewRecord) {
                                        echo Html::activeHiddenInput($modelPlanoMaterial, "[{$index}]id");
                                    }
                                ?>

                                    <div class="col-sm-6">
                                    <?php
                                         $data_repositorio = ArrayHelper::map($repositorio, 'rep_codrepositorio', 'rep_titulo');
                                         echo $form->field($modelPlanoMaterial, "[{$index}]plama_codrepositorio")->widget(Select2::classname(), [
                                                 'data' =>  $data_repositorio,
                                                 'options' => ['placeholder' => 'Selecione o Material Didático...',
                                                 'onchange'=>'
                                                         $.get( "'.Url::toRoute('/planos/planodeacao/get-repositorio').'", { repId: $(this).val() } )
                                                         .done(function( data ) {
                                                             var data = $.parseJSON(data);
                                                            ;
                                                                
                                                         $( "#'.Html::getInputId($modelPlanoMaterial,"[{$index}]plama_valor").'" ).val( data.rep_valor );
                                                         $( "#'.Html::getInputId($modelPlanoMaterial,"[{$index}]plama_tipomaterial").'" ).val( data.rep_codtipo );
                                                             }
                                                         );
                                                         '
                                                 ]]);
                                      ?>
                                    </div>

                                    <div class="col-sm-2">
                                        <?= $form->field($modelPlanoMaterial, "[{$index}]plama_valor")->textInput(['readonly'=> true]) ?>
                                    </div>

                                    <div class="col-sm-2">
                                        <?= $form->field($modelPlanoMaterial, "[{$index}]plama_tipomaterial")->textInput(['readonly'=> true]) ?>
                                    </div>

                                    <div class="col-sm-2">
                                            <?php
                                                        $data_tipoplanomaterial = ArrayHelper::map($tipoplanomaterial, 'tiplama_codtiplama', 'tiplama_descricao');
                                                        echo $form->field($modelPlanoMaterial, "[{$index}]plama_codtiplama")->widget(Select2::classname(), [
                                                                'data' =>  $data_tipoplanomaterial,
                                                                'options' => ['placeholder' => 'Selecione o tipo de plano...'],
                                                                'pluginOptions' => [
                                                                        'allowClear' => true
                                                                    ],
                                                                ]);
                                            ?>
                                    </div>
                                    
                                    <div class="col-sm-12">
                                        <?= $form->field($modelPlanoMaterial, "[{$index}]plama_observacao")->textInput() ?>
                                    </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php DynamicFormWidget::end(); ?>


<?php

//request plano material
// $script = <<< JS
// $('#select[id]').change(function(){
//     var repId = $(this).val();

//     $.get('index.php?r=planos/planodeacao/get-repositorio',{ repId : repId } , function(data){
//         var data = $.parseJSON(data);
//          $('#planomaterial-0-plama_valor').attr('value',data.rep_valor);
//          $('#planomaterial-0-plama_tipomaterial').attr('value',data.rep_codtipo);
//     });
// });

// JS;
// $this->registerJs($script);

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