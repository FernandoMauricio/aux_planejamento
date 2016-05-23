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
                                            'widgetContainer' => 'dynamicform_planomaterial', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                            'widgetBody' => '.container-items-planomaterial', // required: css class selector
                                            'widgetItem' => '.item-planomaterial', // required: css class
                                            'limit' => 4, // the maximum times, an element can be cloned (default 999)
                                            'min' => 1, // 0 or 1 (default 1)
                                            'insertButton' => '.add-item-planomaterial', // css class
                                            'deleteButton' => '.remove-item-planomaterial', // css class
                                            'model' => $modelsPlanoMaterial[0],
                                            'formId' => 'dynamic-form',
                                            'formFields' => [
                                                'plama_codrepositorio',
                                                'plama_valor',
                                                'plama_tipomaterial',
                                                'plama_editora',
                                                'plama_observacao',
                                                'plama_arquivo',
                                            ],
                                        ]); ?>


        <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="glyphicon glyphicon-list-alt"></i> Listagem de Materias Didáticos
                    <button type="button" class="pull-right add-item-planomaterial btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"></i> Adicionar Item</button>
                    <div class="clearfix"></div>
                </div>
                <div class="panel-body container-items-planomaterial"><!-- widgetContainer -->
                    <?php foreach ($modelsPlanoMaterial as $index => $modelPlanoMaterial): ?>
                        <div class="item-planomaterial panel panel-default"><!-- widgetBody -->
                            <div class="panel-heading">
                                <span class="panel-title-planomaterial">Item: <?= ($index + 1) ?></span>
                                <button type="button" class="pull-right remove-item-planomaterial btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"></i></button>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?php
                                    // necessary for update action.
                                    if (!$modelPlanoMaterial->isNewRecord) {
                                        echo Html::activeHiddenInput($modelPlanoMaterial, "[{$index}]id");
                                    }
                                ?>

                                    <div class="col-sm-5">
                                    <?php
                                         $data_repositorio = ArrayHelper::map($repositorio, 'rep_codrepositorio', 'rep_titulo');
                                         echo $form->field($modelPlanoMaterial, "[{$index}]plama_codrepositorio")->widget(Select2::classname(), [
                                                 'data' =>  $data_repositorio,
                                                 'options' => ['placeholder' => 'Selecione o Material Didático...',
                                                 'onchange'=>'
                                                         var select = this;
                                                         $.getJSON( "'.Url::toRoute('/planos/planodeacao/get-repositorio').'", { repId: $(this).val() } )
                                                         .done(function( data ) {

                                                                var $divPanelBody =  $(select).parent().parent().parent();

                                                                var $inputValor = $divPanelBody.find("input:eq(0)");
                                                                var $inputTipoMaterial = $divPanelBody.find("input:eq(1)");
                                                                var $inputEditora = $divPanelBody.find("input:eq(2)");
                                                                var $inputArquivo = $divPanelBody.find("input:eq(4)");


                                                                $inputValor.val(data.rep_valor);
                                                                $inputTipoMaterial.val(data.rep_tipo);
                                                                $inputEditora.val(data.rep_editora);
                                                                
                                                                $("#inputArquivo").attr("href", data.rep_arquivo);
                                                                
                                                             });
                                                         '
                                                 ]]);
                                      ?>
                                    </div>

                                    <div class="col-sm-1">
                                        <?= $form->field($modelPlanoMaterial, "[{$index}]plama_valor")->textInput(['readonly'=> true]) ?>
                                    </div>

                                    <div class="col-sm-2">
                                        <?= $form->field($modelPlanoMaterial, "[{$index}]plama_tipomaterial")->textInput(['readonly'=> true]) ?>
                                    </div>

                                    <div class="col-sm-2">
                                        <?= $form->field($modelPlanoMaterial, "[{$index}]plama_editora")->textInput(['readonly'=> true]) ?>
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

                                    <div class="col-sm-12">

                                   <?php echo '<a id="inputArquivo" target="_blank"> Download do Arquivo</a>' ?>
                                    </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php DynamicFormWidget::end(); ?>


<?php
//request plano material
// function onChangeRepositorio() {
//     var select = this;
//     $.getJSON( "'.Url::toRoute('/planos/planodeacao/get-repositorio').'", { repId: $(this).val() } )
//     .done(function( data ) {
//         var $divPanelBody =  $(select).parent().parent().parent();
//         var $inputValor = $divPanelBody.find("input:eq(0)");
//         var $inputTipoMaterial = $divPanelBody.find("input:eq(1)");
        
//         $inputValor.val(data.rep_valor);
//         $inputTipoMaterial.val(data.rep_tipo);
//      });
// };

$js = '
jQuery(".dynamicform_planomaterial").on("afterInsert", function(e, item) {
    jQuery(".dynamicform_planomaterial .panel-title-planomaterial").each(function(index) {
        jQuery(this).html("Item: " + (index + 1))
    });
});

jQuery(".dynamicform_planomaterial").on("afterDelete", function(e) {
    jQuery(".dynamicform_planomaterial .panel-title-planomaterial").each(function(index) {
        jQuery(this).html("Item: " + (index + 1))
    });
});

';

$this->registerJs($js);



?>