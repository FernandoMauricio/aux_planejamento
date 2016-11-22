<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Json;
use yii\helpers\Url;

?>

<div class="panel panel-default">
                <table class="table"> 
                    <thead> 
                        <tr>    
                            <th>Código</th>
                            <th>Título</th>
                            <th>Identificação</th>
                            <th>Programado</th>
                            <th>Reforço (+) Redução (-)</th>
                            <th>Dotação Final</th>
                        </tr> 
                    </thead> 
                        <?php foreach ($modelsDetalhesModeloA as $i => $modelDetalhesModeloA): ?>
                    <tbody> 
                        <tr class="default"> 

                                            <td style="width: 120px;"><?= $form->field($modelDetalhesModeloA, "[{$i}]deta_codtitulo")->textInput(['readonly'=> true])->label(false); ?></td>

                                            <td><?= $form->field($modelDetalhesModeloA, "[{$i}]deta_titulo")->textInput(['readonly'=> true])->label(false); ?></td>

                                            <td style="width: 20px;"><?= $form->field($modelDetalhesModeloA, "[{$i}]deta_identificacao")->textInput(['readonly'=> true])->label(false); ?></td>

                                            <td style="width: 150px;"><?= $form->field($modelDetalhesModeloA, "[{$i}]deta_programado")->widget(\yii\widgets\MaskedInput::className(), [
                                                                                        'clientOptions' => [
                                                                                        'alias' => 'decimal',
                                                                                        ],
                                                                                        'options' => ['readonly' => $model->moda_codentrada != 1 ?  true : false, 'class' => 'form-control']
                                                                                ])->label(false); ?></td>
                                            <td style="width: 150px;"><?= $form->field($modelDetalhesModeloA, "[{$i}]deta_reforcoreducao")->widget(\yii\widgets\MaskedInput::className(), [
                                                                                        'clientOptions' => [
                                                                                        'alias' => 'decimal',
                                                                                        ],
                                                                                        'options' => ['readonly' => $model->moda_codentrada != 2 ?  true : false, 'class' => 'form-control']
                                                                                ])->label(false); ?></td>

                                            <th style="width: 150px;"><?= $form->field($modelDetalhesModeloA, "[{$i}]deta_dotacaofinal")->widget(\yii\widgets\MaskedInput::className(), [
                                                                                        'clientOptions' => [
                                                                                        'alias' => 'decimal',
                                                                                        ],
                                                                                        'options' => ['readonly' => true, 'class' => 'form-control','style'=> $modelDetalhesModeloA->deta_dotacaofinal < 0 ? 'color:red' : 'color:green']
                                                                                ])->label(false); ?> </th>
                        </tr> 
                        <?php endforeach; ?>
            </tbody> 
        </table>
</div>

<?php  $this->registerJsFile(Yii::$app->request->baseUrl.'/js/modeloa.js', ['depends' => [\yii\web\JqueryAsset::className()]]); ?>