<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use app\models\despesas\Custosindireto;
use app\models\despesas\Salas;

/* @var $this yii\web\View */
/* @var $model app\models\despesas\Custosunidade */

$this->title = $model->cust_codcusto;
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Custos da Unidade', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

//Pega as mensagens
foreach (Yii::$app->session->getAllFlashes() as $key => $message) {
echo '<div class="alert alert-'.$key.'">'.$message.'</div>';
}

?>
<div class="custosunidade-view">

    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="glyphicon glyphicon-book"></i> DETALHES DE CUSTOS DA UNIDADE</h3>
      </div>
        <div class="panel-body">
            <div class="row">
        <?php

        $attributes = [

        //-------------- SESSÃO 1 INFORMAÇÕES DA SOLICITAÇÃO
                    [
                        'group'=>true,
                        'label'=>'SEÇÃO 1: Informações da Unidade',
                        'rowOptions'=>['class'=>'info']
                    ],


                    [
                        'columns' => [
                            [
                                'attribute'=>'cust_codcusto', 
                                'displayOnly'=>true,
                                'valueColOptions'=>['style'=>'width:0%'],
                                'labelColOptions'=>['style'=>'width:5%'],
                            ],

                            [
                                'attribute'=>'cust_codunidade', 
                                'displayOnly'=>true,
                                'value'=> $model->unidade->uni_nomeabreviado,
                                'valueColOptions'=>['style'=>'width:0%'],
                                'labelColOptions'=>['style'=>'width:10%'],
                            ],

                            [
                                'attribute'=>'cust_status', 
                                'format'=>'raw',
                                'type'=>DetailView::INPUT_SWITCH,
                                'value'=>$model->cust_status ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>',
                                'valueColOptions'=>['style'=>'width:30%'],
                                'labelColOptions'=>['style'=>'width:10%'],
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
                              <!-- SEÇÃO 2 - INFORMAÇÕES DE CUSTOS -->
    <table class="table table-condensed table-hover">
      <thead>
      <tr class="info"><th colspan="12">SEÇÃO 2: Informações de Custos</th></tr>
      <tr>
        <th colspan="3" style="text-align: center;">Descrição dos Espaços Físicos</th>
        <th colspan="1" style="text-align: center;">Média Mensal</th>
        <th colspan="1" style="text-align: center;">Custo Indireto</th>
      </tr>
        <tr>
          <th>Salas</th>
          <th>Cap. Máx. de Alunos</th>
          <th>Metragem</th>
          <th>Valores em %</th>
          <th>Valores em $</th>
        </tr>
      </thead>
      <tbody>
          <?php
               //Valores Totais (Cap. Máxima de Aluno, Metragem, Porcentagem, Custo Indireto)
               $valorTotal = 0;
               $valorTotalMetragem = 0;
               $valorTotalPorcentagem = 0;
               $valorTotalCustoIndireto = 0;

               //realiza a soma da capitação máxima de alunos
               $query = (new \yii\db\Query())->from('db_apl.custosindireto_custin')->where(['custosunidade_id' => $model->cust_codcusto]);
               $somaPorcentagem = $query->sum('custin_capmaximo');

                //busca pelas despesas
                $query_custoIndireto = "SELECT * FROM custosindireto_custin WHERE custosunidade_id = '".$model->cust_codcusto."' ORDER BY id ASC";
                $modelsCustosIndireto = Custosindireto::findBySql($query_custoIndireto)->all(); 
                foreach ($modelsCustosIndireto as $modelCustosIndireto) {

                  $salas_id               = $modelCustosIndireto["salas_id"];
                  $custin_capmaximo       = $modelCustosIndireto["custin_capmaximo"];
                  $custin_metragem        = $modelCustosIndireto["custin_metragem"];
                  $custin_porcentagem     = $modelCustosIndireto["custin_porcentagem"];

                  $porcentagem = $custin_capmaximo / $somaPorcentagem;
                  $custin_custoindireto   = $porcentagem * 458216.66 ;

                  //somatório de todos os valores dos itens
                  $valorTotal              += $modelCustosIndireto["custin_capmaximo"];
                  $valorTotalMetragem      += $modelCustosIndireto["custin_metragem"];
                  $valorTotalPorcentagem   += $porcentagem;   //---------cap. máx. de alunos * 100 / Valor Total de Cap Alunos
                  $valorTotalCustoIndireto += $porcentagem * 458216.66 ; // incluir valores dinamicos nesse campo ---PENDENTE 

                //busca pelas salas de cada despesa
                $query_salas = "SELECT sal_descricao FROM `salas_sal`, `custosindireto_custin` WHERE `sal_codsala`= '".$salas_id."' ";
                $modelsSalas = Salas::findBySql($query_salas)->all(); 

                foreach ($modelsSalas as $modelSalas) {

                  $sal_descricao  = $modelSalas["sal_descricao"];
              }
          ?>
          <tr>
          <td><?php echo $sal_descricao ?></td>
          <td><?php echo $custin_capmaximo ?></td>
          <td><?php echo $custin_metragem ?></td>
          <td><?php echo number_format(($porcentagem * 100), 2) . "%" ?></td>
          <td><?php echo 'R$ ' . number_format($custin_custoindireto, 2, ',', '.') ?></td>
        </tr>
          <?php
            }
          ?>
      </tbody>
       <tfoot>
              <tr class="warning kv-edit-hidden" style="border-top: #dedede">
                <th>TOTAL </th>
                 <th style="color:red"><?php echo $valorTotal ?></th>
                 <th style="color:red"><?php echo $valorTotalMetragem ?></th>
                 <th style="color:red"><?php echo ($valorTotalPorcentagem * 100). "%" ?></th>
                 <th style="color:red"><?php echo 'R$ ' . number_format($valorTotalCustoIndireto, 2, ',', '.') ?></th>

              </tr>
           </tfoot>
    </table>

            </div>
        </div>
    </div>

</div>
