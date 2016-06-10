<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\solicitacoes\MaterialCopias */

$this->title = $model->matc_id;
$this->params['breadcrumbs'][] = ['label' => 'Solicitações de Cópias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//Pega as mensagens
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

?>
<div class="material-copias-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->matc_id], ['class' => 'btn btn-primary']) ?>

    </p>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> DETALHES DA SOLICITAÇÃO DE CÓPIA</h3>
  </div>
    <div class="panel-body">
          <div class="row">

  <?php
$attributes = [

//-------------- SESSÃO 1 INFORMAÇÕES DA SOLICITAÇÃO
                [
                    'group'=>true,
                    'label'=>'SEÇÃO 1: Informações da Solicitação',
                    'rowOptions'=>['class'=>'info']
                ],

                [
                    'columns' => [
                        [
                            'attribute'=>'matc_id', 
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:0%'],
                            'labelColOptions'=>['style'=>'width:0%'],
                        ],

                        [
                            'attribute'=>'matc_data', 
                            'displayOnly'=>true,
                            'format'=>['date','php:d/m/Y'],
                            'valueColOptions'=>['style'=>'width:0%'],
                        ],

                        [
                            'attribute'=>'situacao_id', 
                            'format'=>'raw',
                            'type'=>DetailView::INPUT_SWITCH,
                            'value'=>$model->situacao_id ? '<span class="label label-warning">Enviado para Autorização</span>' : '<span class="label label-danger">Autorizado</span>',
                            'valueColOptions'=>['style'=>'width:20%'],
                        ],
                    ],
                ],

                [
                    'columns' => [
                        [
                            'attribute'=>'matc_solicitante', 
                            'displayOnly'=>true,
                            'value'=> $model->colaborador->usuario->usu_nomeusuario,
                            'valueColOptions'=>['style'=>'width:30%'],
                            'labelColOptions'=>['style'=>'width:0%'],
                        ],

                        [
                            'attribute'=>'matc_unidade', 
                            'displayOnly'=>true,
                            'value'=> $model->unidade->uni_nomeabreviado,
                            'valueColOptions'=>['style'=>'width:40%'],
                            'labelColOptions'=>['style'=>'width:0%'],
                        ],

                    ],
                ],

                [
                    'columns' => [
                        [
                            'attribute'=>'matc_descricao', 
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%'],
                            'labelColOptions'=>['style'=>'width:0%'],
                        ],

                        [
                            'attribute'=>'matc_curso', 
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:40%'],
                            'labelColOptions'=>['style'=>'width:0%'],
                        ],

                        [
                            'attribute'=>'matc_centrocusto', 
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:30%'],
                            'labelColOptions'=>['style'=>'width:15%'],
                        ],

                    ],
                ],

//-------------- SESSÃO 2 INFORMAÇÕES FINANCEIRAS
                [
                    'group'=>true,
                    'label'=>'SEÇÃO 2: Informações Financeiras',
                    'rowOptions'=>['class'=>'info']
                ],

                [
                    'columns' => [
                        [
                            'attribute'=>'matc_qtoriginais', 
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:10%'],
                            'labelColOptions'=>['style'=>'width:10%'],
                        ],

                        [
                            'attribute'=>'matc_qtexemplares', 
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:10%'],
                            'labelColOptions'=>['style'=>'width:10%'],
                        ],


                    ],

                ],

                [
                    'columns' => [

                        [
                            'attribute'=>'matc_mono', 
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:10%'],
                            'labelColOptions'=>['style'=>'width:10%'],
                        ],

                        [
                            'attribute'=>'matc_color', 
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:10%'],
                            'labelColOptions'=>['style'=>'width:10%'],
                        ],

                    ],

                ],

                [
                    'columns' => [

                        [
                            'attribute'=>'matc_qteTotal', 
                            'displayOnly'=>true,
                            'valueColOptions'=>['style'=>'width:75%'],
                            'labelColOptions'=>['style'=>'width:0%'],
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

                    <!-- TOTAIS -->
<table class="table table-striped table-hover">
    <tbody>

               <tr class="warning" style="border-top: #dedede">
               <td>Subtotal Mono<i> (Qte Exemplares * Mono) * R$ 0,1</i></td>
               <td style="color:red"><?php echo 'R$ ' . number_format($model->matc_totalValorMono, 2, ',', '.') ?></td>

            </tr>

               <tr class="warning" style="border-top: #dedede">
               <td>Subtotal Color<i> (Qte Exemplares * Color) * R$ 0,6</i></td>
               <td style="color:red"><?php echo 'R$ ' . number_format($model->matc_totalValorColor, 2, ',', '.') ?></td>
        </tr>

   
               <?php
               //somatória de Quantidade * Valor de todas as linhas
               $query = (new \yii\db\Query())->from('db_apl.materialcopias_matc')->where(['matc_id' => $model->matc_id]);
               $sum = $query->sum('matc_totalValorMono+matc_totalValorColor');
               ?>
               <tr class="warning" style="border-top: #dedede">
               <td>TOTAL GERAL<i> (Total Mono + Total Color)</i></td>
               <td style="color:red"><?php echo 'R$ ' . number_format($sum, 2, ',', '.') ?></td>
        </tr>
    </tbody>

  </table>

            </div>
        </div>
    </div>
</div>