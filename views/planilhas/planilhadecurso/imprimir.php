<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\planos\NivelUnidadesCurriculares;
use app\models\planos\Unidadescurriculares;
use app\models\planos\PlanoMaterial;
use app\models\planos\PlanoConsumo;
use app\models\planos\PlanoAluno;
use app\models\planos\PlanoEstruturafisica;

?>
<div class="planilhadecurso-view">
<td width="21%"><img src="<?php echo Url::base().'/uploads/logo.png' ?>" height="90px"></td>

                    <?= $this->render('view-planilha', [
                        'model' => $model,
                        'modelsPlaniDespDocente' => $modelsPlaniDespDocente,
                    ]) ?>

                    <?= $this->render('view-orgcurricular', [
                        'modelsPlaniUC'     => $modelsPlaniUC,
                    ]) ?>

                    <?= $this->render('view-materiaisdidaticos', [
                        'modelsPlaniMaterial' => $modelsPlaniMaterial,
                    ]) ?>
            
                    <?= $this->render('view-materiaisconsumo', [
                        'modelsPlaniConsumo' => $modelsPlaniConsumo,
                    ]) ?>

                    <?= $this->render('view-materiaisaluno', [
                        'modelsPlaniMateriaisAluno' => $modelsPlaniMateriaisAluno,
                    ]) ?>

                    <?= $this->render('view-equipamentos', [
                        'modelsPlaniEquipamento' => $modelsPlaniEquipamento,
                    ]) ?>

      </div>
      