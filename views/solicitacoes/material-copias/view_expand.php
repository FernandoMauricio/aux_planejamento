<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\solicitacoes\Acabamento;

/* @var $this yii\web\View */
/* @var $model app\models\solicitacoes\MaterialCopias */
?>
<div class="material-copias-view">

<div class="panel panel-info">
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
                            'value'=>$model->situacao->sitmat_descricao,
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

                <!-- SESSÃO 3 SERVIÇOS DE ACABAMENTO -->
  <table class="table table-condensed table-hover">
    <thead>
    <tr class="info"><th colspan="12">SEÇÃO 3: Serviços de Acabamento</th></tr>
    </thead>
    <tbody>
        <tr>
        <td colspan="3"><strong>Acabamentos: </strong>
            <?php

  $query_acabamento = "SELECT acab_descricao FROM acabamento_acab, copiasacabamento_copac WHERE materialcopias_id = '".$model->matc_id."' AND acabamento_id = acabamento_acab.id";
  $acabamento = Acabamento::findBySql($query_acabamento)->all(); 
  foreach ($acabamento as $acabamentos) {
   $Acabamento = $acabamentos["acab_descricao"];
   ?>

    <?php echo $Acabamento . " / " ?>

   <?php } ?>
            </td>
        </tr> 
    </tbody>
 </table>
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
               <td style="color:red"><strong><?php echo 'R$ ' . number_format($sum, 2, ',', '.') ?></strong></td>
        </tr>
    </tbody>

  </table>
                        <!-- CAIXA DE AUTORIZAÇÃO DEP -->
<div class="container">
<div class="row">
<div class="col-md-6">
    <?php if($model->matc_ResponsavelAut != NULL){ ?>

     <table class="table" colspan="2"  border="1" style="max-width: 30%; margin-left:5%">
        <thead>
          <tr>
            <th class="warning" colspan="2" style="border-top: #dedede;text-align: center;">AUTORIZAÇÃO</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="2" style="text-align: center;">

            <?php echo $model->matc_autorizado ? '<span class="label label-success">AUTORIZADO. À REPROGRAFIA PARA PROVIDÊNCIAS</span>' : '<span class="label label-danger">NÃO AUTORIZADO</span>' ?>

          </tr>
          <tr>
            <td colspan="2"><strong>Responsável:</strong> <?php echo $model->matc_ResponsavelAut ?></td>
          </tr>
          <tr>
            <td colspan="2"><strong>Data</strong>: <?php echo date('d/m/Y à\s H:i', strtotime( $model->matc_dataAut )) ?></td>
          </tr>
        </tbody>
      </table>

      <?php } ?>
</div>
                        <!-- CAIXA DE DE ENCAMINHAMENTO REPROGRAFIA -->


    <?php if($model->matc_ResponsavelRepro != NULL){ ?>
<div class="col-md-6">
     <table class="table" colspan="2"  border="1" style="max-width: 50%; margin-left:5%">
        <thead>
          <tr>
            <th class="warning" colspan="2" style="border-top: #dedede;text-align: center;">REPROGRAFIA</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="2" style="text-align: center;">

    <?php echo $model->matc_encaminhadoRepro ? '<span class="label label-warning">ENCAMINHADO À TERCEIRIZADA</span>' : '<span class="label label-info">ENCAMINHADO PARA PRODUÇÃO INTERNA</span>' ?>

          </tr>
          <tr>
            <td colspan="2"><strong>Responsável:</strong> <?php echo $model->matc_ResponsavelRepro ?></td>
          </tr>
          <tr>
            <td colspan="2"><strong>Data</strong>: <?php echo date('d/m/Y à\s H:i', strtotime( $model->matc_dataRepro )) ?></td>
          </tr>
        </tbody>
      </table>

      <?php } ?>
      </div>
  </div>
</div>
            </div>
        </div>
    </div>
</div>