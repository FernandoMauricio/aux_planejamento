<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\planos\PlanoMaterial;
use app\models\planos\PlanoConsumo;
use app\models\planos\PlanoAluno;
use app\models\planos\PlanoEstruturafisica;

/* @var $this yii\web\View */
/* @var $model app\models\planos\Planodeacao */

$this->title = $model->plan_codplano . ' - ' .$model->plan_descricao;
$this->params['breadcrumbs'][] = ['label' => 'Listagem de Planos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php

//RESGATANDO AS INFORMAÇÕES
$id = $model->plan_codplano;

?>

<div class="planodeacao-view">

    <h1><?= Html::encode($this->title) ?></h1>
<div class="panel panel-primary">
  <div class="panel-heading">
    <h3 class="panel-title" align="center">DETALHES DO PLANO</h3>
  </div>
    <div class="panel-body">
          <div class="row">

    <?php

    echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'plan_codplano',
            'plan_descricao',

            [
                'attribute' => 'plan_codnivel',
                'value' => $model->nivel->niv_descricao,
            ],

            [
                'attribute' => 'plan_codeixo',
                'value' => $model->eixo->eix_descricao,
            ],

            [
                'attribute' => 'plan_codsegmento',
                'value' => $model->segmento->seg_descricao,
            ],

            [
                'attribute' => 'plan_codtipoa',
                'value' => $model->tipo->tip_descricao,
            ],



            'plan_cargahoraria',
            'plan_sobre:ntext',
            'plan_prerequisito:ntext',
            'plan_orgcurricular:ntext',
            'plan_perfTecnico:ntext',
            //'plan_codcolaborador',

            [
                'attribute' => 'plan_codtipoa',
                'value' => $model->colaborador->usuario->usu_nomeusuario,
            ],

            [
                'attribute' => 'plan_data',
                'format' => ['date', 'php:d/m/Y'],
            ],

            [
                'attribute'=>'plan_status', 
                'label'=>'Situação',
                'format'=>'raw',
                'value'=>$model->plan_status ? '<span class="label label-success">Ativo</span>' : '<span class="label label-danger">Inativo</span>',
                'valueColOptions'=>['style'=>'width:100%']
            ],
        ],
    ]) 
    ?>

</div>


  <h3>Materiais Didáticos</h3>
  <table class="table table-condensed table-hover">
    <thead>
      <tr>
        <th>Descrição</th>
        <th>Valor Unitário</th>
        <th>Tipo Material</th>
        <th>Editora</th>
        <th>Plano</th>
        <th>Observação</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php
             $valorTotal = 0;
             $query_planoMaterial = "SELECT * FROM planomaterial_plama WHERE plama_codplano = '".$id."' ORDER BY plama_tipoplano ASC";
             $modelsPlanoMaterial = PlanoMaterial::findBySql($query_planoMaterial)->all(); 
             foreach ($modelsPlanoMaterial as $modelPlanoMaterial) {
                
                $plama_titulo       = $modelPlanoMaterial["plama_titulo"];
                $plama_valor        = $modelPlanoMaterial["plama_valor"];
                $plama_tipomaterial = $modelPlanoMaterial["plama_tipomaterial"];
                $plama_editora      = $modelPlanoMaterial["plama_editora"];
                $plama_tipoplano    = $modelPlanoMaterial["plama_tipoplano"];
                $plama_observacao   = $modelPlanoMaterial["plama_observacao"];
                $valorTotal        += $modelPlanoMaterial["plama_valor"]; //somatório de todos os valores dos itens

        ?>
        <td><?php echo $plama_titulo ?></td>
        <td><?php echo 'R$ ' . number_format($plama_valor, 2, ',', '.') ?></td>
        <td><?php echo $plama_tipomaterial ?></td>
        <td><?php echo $plama_editora ?></td>
        <td><?php echo $plama_tipoplano ?></td>
        <td><?php echo $plama_observacao ?></td>
      </tr>
        <?php
          }
        ?>
    </tbody>
     <tfoot>
            <tr>
              <th>TOTAL <i>(Valor Unitário)</i> </th>
               <th style="color:red"><?php echo 'R$ ' . number_format($valorTotal, 2, ',', '.') ?></th>
            </tr>
         </tfoot>
  </table>


  <h3>Materiais de Consumo</h3>
  <table class="table table-condensed table-hover">
    <thead>
      <tr>
        <th>Descrição</th>
        <th>Valor Unitário</th>
        <th>Quantidade</th>
        <th>Unidade</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php
             $valorTotal = 0;
             $query_planoConsumo = "SELECT * FROM plano_materialconsumo WHERE planodeacao_cod = '".$id."' ORDER BY planmatcon_cod ASC";
             $modelsPlanoConsumo = PlanoConsumo::findBySql($query_planoConsumo)->all(); 
             foreach ($modelsPlanoConsumo as $modelPlanoConsumo) {
                
                $planmatcon_descricao  = $modelPlanoConsumo["planmatcon_descricao"];
                $planmatcon_valor      = $modelPlanoConsumo["planmatcon_valor"];
                $planmatcon_tipo       = $modelPlanoConsumo["planmatcon_tipo"];
                $planmatcon_quantidade = $modelPlanoConsumo["planmatcon_quantidade"];
                $valorTotal           += $modelPlanoConsumo["planmatcon_valor"]; //somatório de todos os valores dos itens

        ?>
        <td><?php echo $planmatcon_descricao ?></td>
        <td><?php echo 'R$ ' . number_format($planmatcon_valor, 2, ',', '.') ?></td>
        <td><?php echo $planmatcon_quantidade ?></td>
        <td><?php echo $planmatcon_tipo ?></td>

      </tr>
        <?php
          }
        ?>
    </tbody>
     <tfoot>
            <tr>
               <?php
               //somatória de Quantidade * Valor de todas as linhas
               $query = (new \yii\db\Query())->from('db_apl.plano_materialconsumo')->where(['planodeacao_cod' => $id]);
               $sum = $query->sum('planmatcon_valor*planmatcon_quantidade');
               ?>
               <th>TOTAL <i>(Valor Unitário * Quantidade)</i></th>
               <th style="color:red"><?php echo 'R$ ' . number_format($sum, 2, ',', '.') ?></th>
            </tr>
         </tfoot>
  </table>


  <h3>Materiais do Aluno</h3>
  <table class="table table-condensed table-hover">
    <thead>
      <tr>
        <th>Descrição</th>
        <th>Valor Unitário</th>
        <th>Quantidade</th>
        <th>Unidade</th>
        <th>Tipo</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php
             $valorTotal = 0;
             $query_planoAluno = "SELECT * FROM plano_materialaluno WHERE planodeacao_cod = '".$id."' ORDER BY planmatalu_tipo ASC";
             $modelsPlanoAluno = PlanoAluno::findBySql($query_planoAluno)->all(); 
             foreach ($modelsPlanoAluno as $modelPlanoAluno) {
                
                $planmatalu_descricao  = $modelPlanoAluno["planmatalu_descricao"];
                $planmatalu_valor      = $modelPlanoAluno["planmatalu_valor"];
                $planmatalu_unidade    = $modelPlanoAluno["planmatalu_unidade"];
                $planmatalu_quantidade = $modelPlanoAluno["planmatalu_quantidade"];
                $planmatalu_tipo       = $modelPlanoAluno["planmatalu_tipo"];
                $valorTotal           += $modelPlanoAluno["planmatalu_valor"]; //somatório de todos os valores dos itens
        ?>
        <td><?php echo $planmatalu_descricao ?></td>
        <td><?php echo 'R$ ' . number_format($planmatalu_valor, 2, ',', '.') ?></td>
        <td><?php echo $planmatalu_quantidade ?></td>
        <td><?php echo $planmatalu_unidade ?></td>
        <td><?php echo $planmatalu_tipo ?></td>

      </tr>
        <?php    }   ?>
    </tbody>
     <tfoot>
            <tr>
               <th>TOTAL <i>(Valor Unitário * Quantidade)</i></th>

               <?php
               //somatória de Quantidade * Valor de todas as linhas
               $query = (new \yii\db\Query())->from('db_apl.plano_materialaluno')->where(['planodeacao_cod' => $id]);
               $sum = $query->sum('planmatalu_valor*planmatalu_quantidade');
               ?>
               <th style="color:red"><?php echo 'R$ ' . number_format($sum, 2, ',', '.') ?></th>
            </tr>
         </tfoot>
  </table>

  <h3>Estrutura Física do Plano</h3>
  <table class="table table-condensed table-hover">
    <thead>
      <tr>
        <th>Descrição</th>
        <th>Quantidade</th>
        <th>Tipo</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <?php
             $query_PlanoEstrutura = "SELECT * FROM plano_estruturafisica WHERE planodeacao_cod = '".$id."' ORDER BY planestr_tipo ASC";
             $modelsPlanoEstrutura = PlanoEstruturafisica::findBySql($query_PlanoEstrutura)->all(); 
             foreach ($modelsPlanoEstrutura as $modelPlanoEstrutura) {
                
                $planestr_descricao  = $modelPlanoEstrutura["planestr_descricao"];
                $planestr_quantidade = $modelPlanoEstrutura["planestr_quantidade"];
                $planestr_tipo       = $modelPlanoEstrutura["planestr_tipo"];
        ?>
        <td><?php echo $planestr_descricao ?></td>
        <td><?php echo $planestr_quantidade ?></td>
        <td><?php echo $planestr_tipo ?></td>

      </tr>
        <?php    }   ?>
    </tbody>
  </table>


         </div>

    </div>
</div>