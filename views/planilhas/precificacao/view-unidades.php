<?php

use app\models\planilhas\PrecificacaoUnidades;
use app\models\base\Unidade;

?>

<div class="precificacao2-view">

 <div class="row">
     <p class="bg-info" style="padding: 10px; text-align: center;"><strong> PLANILHA DE CUSTO E FORMAÇÃO DE PREÇO DE VENDA <br>
     <span style="color: #F7941D;"><?php echo $model->planodeacao->plan_descricao; ?></strong></span>
     </p>
</div>

  <table class="table table-condensed table-hover">
    <thead>
      <tr>
        <th style="font-size:10px;">Unidade</th>
        <th style="font-size:10px;">Carga Horária</th>
        <th style="font-size:10px;">Qnt Alunos</th>
        <th style="font-size:10px;">Total Custo Direto</th>
        <th style="font-size:10px;">Valor Total da Turma</th>
        <th style="font-size:10px;">Valor Por Aluno</th>
        <th style="font-size:10px;">Valor Hora/Aula</th>
        <th style="font-size:10px;">Preço de Venda</th>
      </tr>
    </thead>

    <tbody>
        <?php
            //realiza a soma do valor total da turma das unidades
            $query = (new \yii\db\Query())->from('db_apl2.precificacao_unidades')->where(['precificacao_id' => $model->planp_id]);
            $totalVendaTurma = $query->sum('uprec_vendaturma');

            //realiza a soma do valor por aluno
            $queryVendaAluno = (new \yii\db\Query())->from('db_apl2.precificacao_unidades')->where(['precificacao_id' => $model->planp_id]);
            $totalVendaAluno = $queryVendaAluno->sum('uprec_vendaaluno');

            //realiza a soma do valor por aluno
            $queryHoraAula = (new \yii\db\Query())->from('db_apl2.precificacao_unidades')->where(['precificacao_id' => $model->planp_id]);
            $totalHoraAula = $queryHoraAula->sum('uprec_horaaula');

            //Busca no banco o quantitativo de Precificação das unidades configuradas pelo Markup
            $sql = "SELECT * FROM precificacao_unidades WHERE precificacao_id = '".$model->planp_id."'";
            $qnt_unidades = PrecificacaoUnidades::findBySql($sql)->count();

            $MediaVendaTurma = $totalVendaTurma / $qnt_unidades;
            $MediaVendaAluno = $totalVendaAluno / $qnt_unidades;
            $MediaHoraAula   = $totalHoraAula   / $qnt_unidades;

            $query_ListagemPrecificacao = "SELECT * FROM precificacao_unidades WHERE precificacao_id = '".$model->planp_id."'";
            $modelsPrecificacaoUnidades = PrecificacaoUnidades::findBySql($query_ListagemPrecificacao)->all(); 
            foreach ($modelsPrecificacaoUnidades as $modelPrecificacaoUnidades) {

            $query_Unidades = "SELECT * FROM unidade_uni WHERE uni_cidade = 'Manaus' AND uni_codunidade = '".$modelPrecificacaoUnidades['uprec_codunidade']."' ";
            $modelsUnidades = Unidade::findBySql($query_Unidades)->all(); 
            foreach ($modelsUnidades as $modelUnidades) {
         ?>
      <tr><!-- Unidades da Capital--> 
        <td style="font-size:10px;"><?= $modelUnidades['uni_nomeabreviado']; ?></td>
        <td style="font-size:10px;"><?= $modelPrecificacaoUnidades['uprec_cargahoraria']; ?></td>
        <td style="font-size:10px;"><?= $modelPrecificacaoUnidades['uprec_qntaluno']; ?></td>
        <td style="font-size:10px;"><?= 'R$ ' . number_format($modelPrecificacaoUnidades['uprec_totalcustodireto'], 2, ',', '.'); ?></td>
        <td style="font-size:10px;"><?= 'R$ ' . number_format($modelPrecificacaoUnidades['uprec_vendaturma'], 2, ',', '.'); ?></td>
        <td style="font-size:10px;"><?= 'R$ ' . number_format($modelPrecificacaoUnidades['uprec_vendaaluno'], 2, ',', '.'); ?></td>
        <td style="font-size:10px;"><?= 'R$ ' . number_format($modelPrecificacaoUnidades['uprec_horaaula'], 2, ',', '.'); ?></td>
        <td style="font-size:10px;"><?= $modelUnidades['uni_cidade'] == "Manaus" ?  'R$ ' . number_format($model->planp_precosugerido, 2, ',', '.') : 'R$ ' . number_format($model->planp_valorcomdesconto, 2, ',', '.') ?></td>
      </tr>
      <?php
         } 
      }
      ?>
      <?php
         $query_ListagemPrecificacao = "SELECT * FROM precificacao_unidades WHERE precificacao_id = '".$model->planp_id."'";
         $modelsPrecificacaoUnidades = PrecificacaoUnidades::findBySql($query_ListagemPrecificacao)->all(); 
         foreach ($modelsPrecificacaoUnidades as $modelPrecificacaoUnidades) {

         $query_Unidades = "SELECT * FROM unidade_uni WHERE uni_cidade != 'Manaus' AND uni_codunidade = '".$modelPrecificacaoUnidades['uprec_codunidade']."' ";
         $modelsUnidades = Unidade::findBySql($query_Unidades)->all(); 
         foreach ($modelsUnidades as $modelUnidades) {
      ?>
      <tr><!-- Unidades do Interior--> 
        <td style="font-size:10px;"><?= $modelUnidades['uni_nomeabreviado']; ?></td>
        <td style="font-size:10px;"><?= $modelPrecificacaoUnidades['uprec_cargahoraria']; ?></td>
        <td style="font-size:10px;"><?= $modelPrecificacaoUnidades['uprec_qntaluno']; ?></td>
        <td style="font-size:10px;"><?= 'R$ ' . number_format($modelPrecificacaoUnidades['uprec_totalcustodireto'], 2, ',', '.'); ?></td>
        <td style="font-size:10px;"><?= 'R$ ' . number_format($modelPrecificacaoUnidades['uprec_vendaturma'], 2, ',', '.'); ?></td>
        <td style="font-size:10px;"><?= 'R$ ' . number_format($modelPrecificacaoUnidades['uprec_vendaaluno'], 2, ',', '.'); ?></td>
        <td style="font-size:10px;"><?= 'R$ ' . number_format($modelPrecificacaoUnidades['uprec_horaaula'], 2, ',', '.'); ?></td>
        <td style="font-size:10px;"><?= $modelUnidades['uni_cidade'] == "Manaus" ?  'R$ ' . number_format($model->planp_precosugerido, 2, ',', '.') : 'R$ ' . number_format($model->planp_valorcomdesconto, 2, ',', '.') ?></td>
      </tr>
      <?php
         }
      }
      ?>
    </tbody>

    <tfoot>
            <tr class="warning kv-edit-hidden" style="border-top: #dedede">
              <th>Média Total </th>
               <th colspan="1" style="font-size:10px; color:red"><?= $modelPrecificacaoUnidades['uprec_cargahoraria']; ?></th>
               <th colspan="1" style="font-size:10px; color:red"><?= $modelPrecificacaoUnidades['uprec_qntaluno']; ?></th>
               <th colspan="1" style="font-size:10px; color:red"><?= 'R$ ' . number_format($modelPrecificacaoUnidades['uprec_totalcustodireto'], 2, ',', '.'); ?></th>
               <th colspan="1" style="font-size:10px; color:red"><?= 'R$ ' . number_format($MediaVendaTurma, 2, ',', '.'); ?></th>
               <th colspan="1" style="font-size:10px; color:red"><?= 'R$ ' . number_format($MediaVendaAluno, 2, ',', '.'); ?></th>
               <th colspan="1" style="font-size:10px; color:red"><?= 'R$ ' . number_format($MediaHoraAula, 2, ',', '.'); ?></th>
               <th colspan="1" style="font-size:10px; color:red"><?= 'R$ ' . number_format($model->planp_precosugerido, 2, ',', '.'); ?></th>
            </tr>
    </tfoot>
  </table>
</div>
