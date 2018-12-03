<?php

use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\planos\PlanoAluno;

?>

<td width="21%"><img src="<?php echo Url::base().'/uploads/logo.png' ?>" height="100px"></td><br><br>
 <table class="table table-condensed table-hover">
    <thead>
    <tr class="info"><th colspan="12" style="text-align: center;">MATERIAIS DO ALUNO</th></tr>
      <tr>
        <th>Descrição</th>
        <th>Quantidade</th>
        <th>Unidade</th>
      </tr>
    </thead>
    <tbody>
        <?php
             $valorTotal = 0;
             $query_planoAluno = "SELECT * FROM plano_materialaluno WHERE planodeacao_cod = '".$model->plan_codplano."' ORDER BY planmatalu_tipo ASC";
             $modelsPlanoAluno = PlanoAluno::findBySql($query_planoAluno)->all(); 
             foreach ($modelsPlanoAluno as $modelPlanoAluno) {
                
                $planmatalu_descricao  = $modelPlanoAluno["planmatalu_descricao"];
                $planmatalu_valor      = $modelPlanoAluno["planmatalu_valor"];
                $planmatalu_unidade    = $modelPlanoAluno["planmatalu_unidade"];
                $planmatalu_quantidade = $modelPlanoAluno["planmatalu_quantidade"];
                $planmatalu_tipo       = $modelPlanoAluno["planmatalu_tipo"];
                $valorTotal           += $modelPlanoAluno["planmatalu_valor"]; //somatório de todos os valores dos itens
        ?>
        <tr>
        <td><?php echo $planmatalu_descricao ?></td>
        <td><?php echo $planmatalu_quantidade ?></td>
        <td><?php echo $planmatalu_unidade ?></td>

      </tr>
        <?php    }   ?>
    </tbody>
     <tfoot>
            <tr class="warning kv-edit-hidden" style="border-top: #dedede">
               <th>TOTAL <i>(Quantidade)</i></th>

               <?php
               //somatória de Quantidade * Valor de todas as linhas
               $query = (new \yii\db\Query())->from('db_apl2.plano_materialaluno')->where(['planodeacao_cod' => $model->plan_codplano]);
               $sum = $query->sum('planmatalu_quantidade');
               ?>
               <th colspan="12" style="color:red"><?php echo $sum . ' itens' ?></th>
            </tr>
         </tfoot>
  </table>
