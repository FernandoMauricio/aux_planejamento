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
                                            <td><?= $modelDetalhesModeloA->deta_codtitulo ?></td>


                                            <td><?= $modelDetalhesModeloA->deta_titulo ?></td>

                                            <td><?= $modelDetalhesModeloA->deta_identificacao ?></td>

                                            <td><?= $form->field($modelDetalhesModeloA, "[{$i}]deta_programado")->widget(\yii\widgets\MaskedInput::className(), [
                                                                                        'clientOptions' => [
                                                                                        'alias' => 'decimal',
                                                                                        ],
                                                                                        'options' => ['readonly' => $model->moda_codentrada != 1 ?  true : false, 'class' => 'form-control']
                                                                                ])->label(false); ?></td>
                                            <td><?= $form->field($modelDetalhesModeloA, "[{$i}]deta_reforcoreducao")->widget(\yii\widgets\MaskedInput::className(), [
                                                                                        'clientOptions' => [
                                                                                        'alias' => 'decimal',
                                                                                        ],
                                                                                        'options' => ['readonly' => $model->moda_codentrada != 2 ?  true : false, 'class' => 'form-control']
                                                                                ])->label(false); ?></td>

                                            <th><?= $form->field($modelDetalhesModeloA, "[{$i}]deta_dotacaofinal")->widget(\yii\widgets\MaskedInput::className(), [
                                                                                        'clientOptions' => [
                                                                                        'alias' => 'decimal',
                                                                                        ],
                                                                                        'options' => ['readonly' => true, 'class' => 'form-control','style'=>'color:red']
                                                                                ])->label(false); ?></th>
                                            </tr> 
                        <?php endforeach; ?>
            </tbody> 
        </table>
</div>