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
    <div class="panel panel-default">
            <div class="panel-heading"> Resumo de Custos Diretos</div><br>
        <div class="container">
              <div class="row">
                      <div class="col-md-3"><strong>Custo de Mão de Obra Direta:</strong><br> <?php echo 'R$ ' . number_format( $model->placu_totalcustodocente, 2, ',', '.'); ?></div>

                      <div class="col-md-2"><strong>1/12 de 13º:</strong><br> <?php echo 'R$ ' . number_format($model->placu_decimo, 2, ',', '.'); ?></div>

                      <div class="col-md-2"><strong>1/12 de Férias:</strong><br> <?php  echo 'R$ ' . number_format($model->placu_ferias, 2, ',', '.'); ?></div>

                      <div class="col-md-2"><strong>1/12 de 1/3 de férias:</strong><br> <?php echo 'R$ ' . number_format( $model->placu_tercoferias, 2, ',', '.'); ?></div>

                      <div class="col-md-2"><strong>Total de Salários:</strong><br> <?php echo 'R$ ' . number_format( $model->placu_totalsalario, 2, ',', '.'); ?></div>
              </div>

            <br>

              <div class="row">
                      <div class="col-md-3"><strong>(%) Encargos s/13º, férias e salários:</strong><br> <?php echo number_format($model->placu_encargos, 2, ',', '.') . '%'; ?></div>

                      <div class="col-md-3"><strong>Total de Encargos:</strong><br> <?php echo 'R$ ' . number_format( $model->placu_totalencargos, 2, ',', '.'); ?></div>

                      <div class="col-md-3"><strong>Total de Salários + Encargos:</strong><br> <?php echo 'R$ ' . number_format( $model->placu_totalsalarioencargo, 2, ',', '.'); ?></div>
              </div>

              <br>

              <div class="row">
                      <div class="col-md-3"><strong>Diárias:</strong><br> <?php echo 'R$ ' . number_format($model->placu_diarias, 2, ',', '.'); ?></div>

                      <div class="col-md-3"><strong>Passagens:</strong><br> <?php echo 'R$ ' . number_format( $model->placu_passagens, 2, ',', '.'); ?></div>

                      <div class="col-md-3"><strong>Serv. Terceiros (PF):</strong><br> <?php echo 'R$ ' . number_format( $model->placu_pessoafisica, 2, ',', '.'); ?></div>

                      <div class="col-md-3"><strong>Serv. Terceiros (PJ):</strong><br> <?php echo 'R$ ' . number_format( $model->placu_pessoajuridica, 2, ',', '.'); ?></div>
              </div>

             <br>

              <div class="row">
                      <div class="col-md-3"><strong>Mat. Didático (Apostila/plano A):</strong><br> <?php echo 'R$ ' .  number_format($model->placu_PJApostila, 2, ',', '.'); ?></div>

                      <div class="col-md-3"><strong>Mat. Didático (Livros/plano A):</strong><br> <?php echo 'R$ ' .  number_format($model->placu_custosmateriais, 2, ',', '.'); ?></div>

                      <div class="col-md-3"><strong>Material Consumo:</strong><br> <?php echo 'R$ ' .  number_format($model->placu_custosconsumo, 2, ',', '.'); ?></div>

                      <div class="col-md-3" style="color: #F7941D;"><strong>Total de Custo Direto:</strong><br> <?php echo 'R$ ' . number_format( $model->placu_totalcustodireto, 2, ',', '.'); ?></div>
              </div>

             <br>

              <div class="row">
                      <div class="col-md-3"><strong>Valor Hora/Aula de Custo Direto:</strong><br> <?php echo 'R$ ' . number_format( $model->placu_totalhoraaulacustodireto, 2, ',', '.'); ?></div>
              </div>

            <br>
        </div>
    </div>

        <div class="row">
            <p class="bg-info" style="padding: 7px; margin-right: 15px; margin-left: 15px;"><strong> SEÇÃO 4: Cálculos de Custos Indiretos</strong></p>
        </div>

</div>
