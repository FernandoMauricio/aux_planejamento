<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use app\models\planos\NivelUnidadesCurriculares;
use app\models\planos\Unidadescurriculares;
use app\models\planos\PlanoMaterial;
use app\models\planos\PlanoConsumo;
use app\models\planos\PlanoAluno;
use app\models\planos\PlanoEstruturafisica;

/* @var $this yii\web\View */
/* @var $model app\models\planilhas\Planilhadecurso */

$this->title = $model->placu_codplanilha;
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Planilhas de Curso', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="planilhadecurso-view">

    <?php
        $attributes = [
                            [
                                'group'=>true,
                                'label'=>'SEÇÃO 1: Informações da Planilha',
                                'rowOptions'=>['class'=>'info']
                            ],

                            [
                                'columns' => [
                                    [
                                        'attribute'=>'placu_codnivel', 
                                        'value'=> $model->nivel->niv_descricao,
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                    [
                                        'attribute'=>'placu_codeixo', 
                                        'value'=> $model->eixo->eix_descricao,
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                    [
                                        'attribute'=>'placu_codsegmento', 
                                        'value'=> $model->segmento->seg_descricao,
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                    [
                                        'attribute'=>'placu_codtipoa', 
                                        'value'=> $model->tipo->tip_descricao,
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                ],
                            ],

                            [
                                'columns' => [
                                    [
                                        'label'=>'Plano de Ação',
                                        'format'=>'raw', 
                                        'value'=>$model->plano->plan_descricao,
                                        'displayOnly'=>true,
                                        'labelColOptions'=>['style'=>'width:0%'],
                                        'valueColOptions'=>['style'=>'width:0%']
                                    ],

                                    [
                                        'attribute'=>'placu_cargahorariaplano', 
                                        'format'=>'raw', 
                                        'value'=>$model->placu_cargahorariaplano,
                                        'valueColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],

                                ],
                            ],

                            [
                                'label'=>'Informações Comerciais',
                                'format' => 'ntext',
                                'value'=> $model->plano->plan_sobre,
                                'type'=>DetailView::INPUT_TEXTAREA, 
                                'options'=>['rows'=>4]
                            ],

                            [
                                'label'=>'Pré-Requisito',
                                'format' => 'ntext',
                                'value'=> $model->plano->plan_prerequisito,
                                'type'=>DetailView::INPUT_TEXTAREA, 
                                'options'=>['rows'=>4]
                            ],

                            [
                                'label'=>'Perfil Profissional de Conclusão',
                                'format' => 'ntext',
                                'value'=> $model->plano->plan_perfConclusao,
                                'type'=>DetailView::INPUT_TEXTAREA, 
                                'options'=>['rows'=>4]
                            ],

                            [
                                'label'=>'Perfil do Docente',
                                'format' => 'ntext',
                                'value'=> $model->plano->plan_perfTecnico,
                                'type'=>DetailView::INPUT_TEXTAREA, 
                                'options'=>['rows'=>4]
                            ],

                            [
                                'group'=>true,
                                'label'=>'SEÇÃO 2: Sobre a Turma',
                                'rowOptions'=>['class'=>'info']
                            ],

                            [
                                'columns' => [
                                    [
                                        'attribute'=>'placu_codano', 
                                        'value'=> $model->planilhaAno->an_ano,
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                    [
                                        'attribute'=>'placu_codtipla', 
                                        'value'=> $model->tipoplanilha->tipla_descricao,
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                    [
                                        'attribute'=>'placu_codprogramacao', 
                                        'value'=> $model->tipoprogramacao->tipro_descricao,
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                    [
                                        'attribute'=>'placu_quantidadeturmas', 
                                        'value'=> $model->placu_quantidadeturmas,
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                ],
                            ],

                            [
                                'columns' => [
                                    [
                                        'attribute'=>'placu_cargahorariarealizada', 
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                    [
                                        'attribute'=>'placu_cargahorariaarealizar', 
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                    [
                                        'attribute'=>'placu_cargahorariavivencia', 
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                ],
                            ],

                            [
                                'columns' => [
                                    [
                                        'attribute'=>'placu_quantidadealunos', 
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                    [
                                        'attribute'=>'placu_quantidadealunospsg', 
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                    [
                                        'attribute'=>'placu_quantidadealunosisentos', 
                                        'labelColOptions'=>['style'=>'width:0%'], 
                                        'displayOnly'=>true
                                    ],
                                ],
                            ],
                    ];

    echo DetailView::widget([
        'model'=>$model,
        'condensed'=>true,
        'hover'=>true,
        'mode'=>DetailView::MODE_VIEW,
        'attributes'=> $attributes,
    ]);

    ?>

        <div class="row">
            <p class="bg-info" style="padding: 7px; margin-right: 15px; margin-left: 15px;"><strong> SEÇÃO 3: Cálculos de Custos Diretos</strong></p>
        </div>
        <table class="table table-condensed table-hover">
         <caption> Despesas com Docente</caption>
          <thead>
            <tr>
              <th>Descrição</th>
              <th>Valor</th>
              <th>DSR</th>
              <th>Planejamento</th>
              <th>Produtividade</th>
              <th>Valor Hora/Aula</th>
              <th>Carga Horária</th>
            </tr>
         </thead>

           <tbody>
               <?php foreach ($modelsPlaniDespDocente as $i => $modelPlaniDespDocente): ?>
            <tr>
                <td><?= $modelPlaniDespDocente->planides_descricao ?></td>
                <td><?= $modelPlaniDespDocente->planides_valor ?></td>
                <td><?= $modelPlaniDespDocente->planides_dsr ?></td>
                <td><?= $modelPlaniDespDocente->planides_planejamento ?></td>
                <td><?= $modelPlaniDespDocente->planides_produtividade ?></td>
                <td><?= $modelPlaniDespDocente->planides_valorhoraaula ?></td>
                <td><?= $modelPlaniDespDocente->planides_cargahoraria ?></td>
            </tr>
               <?php endforeach; ?>
           </tbody>
        </table>


</div>
