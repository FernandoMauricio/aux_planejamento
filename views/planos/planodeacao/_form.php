<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use yii\helpers\Json;
use app\models\cadastros\Eixo;
use app\models\cadastros\Segmento;

/* @var $this yii\web\View */
/* @var $model app\models\planos\Planodeacao */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="planodeacao-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>

    <?= $form->field($model, 'plan_descricao')->textInput(['maxlength' => true]) ?>


    <?php
        $EixoList=ArrayHelper::map(app\models\cadastros\Eixo::find()->all(), 'eix_codeixo', 'eix_descricao' ); 
        echo $form->field($model, 'plan_codeixo')->dropDownList($EixoList, ['id' => 'eixo-id', 'prompt'=>'Selecione o Eixo...']);


        // Child # 1
        echo $form->field($model, 'plan_codsegmento')->widget(DepDrop::classname(), [
            'options'=>['id'=>'segmento-id'],
            'pluginOptions'=>[
                'depends'=>['eixo-id'],
                'placeholder'=>'Selecione o Segmento...',
                'url'=>Url::to(['/planos/planodeacao/segmento'])
            ]
        ]);


        // Child # 2
        echo $form->field($model, 'plan_codtipoa')->widget(DepDrop::classname(), [
            'pluginOptions'=>[
                'depends'=>['segmento-id'],
                'placeholder'=>'Selecione o Tipo de Ação...',
                'url'=>Url::to(['/planos/planodeacao/tipos'])
            ]
        ]);


?>



    <?= $form->field($model, 'plan_codnivel')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_cargahoraria')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'plan_sobre')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_prerequisito')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_orgcurricular')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_perfTecnico')->textarea(['rows' => 6]) ?>


                  <!--            INFORMAÇÕES DAS ESTRUTURAS FÍSICAS DO PLANO                -->

    <?php
            echo $this->render('_form-planoestrutura', [
                'form' => $form,
                'model' => $model,
                'estruturafisica' => $estruturafisica,
                'modelsPlanoEstrutura' => (empty($modelsPlanoEstrutura)) ? [new PlanoEstruturafisica] : $modelsPlanoEstrutura,
            ])
    ?>


    <?= $form->field($model, 'plan_matConsumo')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_matAluno')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'plan_codcolaborador')->textInput() ?>

    <?= $form->field($model, 'plan_data')->textInput() ?>

    <?= $form->field($model, 'plan_status')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Criar Plano' : 'Atualizar Plano', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

