<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

?>

<div class="panel panel-primary">
    <div class="panel-body">
          <div class="row">
  <table class="table table-condensed table-hover">
    <thead>
    <tr class="info"><th colspan="12">SEÇÃO 1: Informações do Curso</th></tr>
    </thead>
    <tbody>
        <tr>
            <td style="font-size:11px;" colspan="1"><strong>Código: </strong> <?= $model->planp_id; ?></td>
            <td style="font-size:11px;" colspan="1"><strong>Ano: </strong> <?= $model->planp_ano; ?></td>
            <td style="font-size:11px;" colspan="5"><strong>Unidade: </strong> <?= $model->unidade->uni_nomeabreviado; ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="2"><strong>Cód. Plano: </strong> <?= $model->planp_planodeacao; ?></td>
            <td style="font-size:11px;" colspan="5"><strong>Plano de Curso: </strong> <?= $model->planodeacao->plan_descricao; ?></td>
            <td style="font-size:11px;" colspan="2"><strong>Carga Horária: </strong><br> <?= $model->planp_cargahoraria; ?></td>
            <td style="font-size:11px;" colspan="2"><strong>Qnt Alunos: </strong><br> <?= $model->planp_qntaluno; ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="12"><strong>Observação: </strong><br> <?= $model->planp_observacao; ?></td>
        </tr>
    </tbody>
 </table>

   <table class="table table-condensed table-hover">
    <thead>
    <tr class="info"><th colspan="12">SEÇÃO 2: Cálculos de Custos Diretos</th></tr>
    </thead>
    <tbody>
        <tr>
            <td style="font-size:11px;" colspan="3"><strong>Nível Docente: </strong> <?= $model->despesasdocente->doce_descricao; ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Total Horas Docente: </strong><br> <?= $model->planp_totalhorasdocente; ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Provisão de Ano: </strong><br> <?= $model->planp_mesesdocurso; ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Hora/Aula S. Pedagógico (s/produtividade): </strong><br> <?= $model->planp_servpedagogico; ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="4"><strong>Valor Hora/Aula: </strong><br> <?= 'R$ ' . number_format($model->planp_valorhoraaula, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="4"><strong>Valor Hora/Aula Planejamento: </strong> <br> <?php  echo 'R$ ' . number_format($model->planp_horaaulaplanejamento, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="4"><strong>Custo de Mão de Obra Direta: </strong> <br> <?= 'R$ ' . number_format( $model->planp_totalcustodocente, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="3"><strong>Provisão de 13º: </strong><br> <?= 'R$ ' . number_format($model->planp_decimo, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Provisão de Férias: </strong><br><?php  echo 'R$ ' . number_format($model->planp_ferias, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Provisão de 1/3 de férias: </strong><br> <?= 'R$ ' . number_format( $model->planp_tercoferias, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Total de Salários: </strong><br> <?= 'R$ ' . number_format( $model->planp_totalsalario, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="4"><strong>(%) Encargos s/13º, férias e salários: </strong><br> <?= number_format($model->planp_encargos, 2, ',', '.') . '%'; ?></td>
            <td style="font-size:11px;" colspan="4"><strong>Total de Encargos: </strong><br> <?= 'R$ ' . number_format( $model->planp_totalencargos, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="4"><strong>Total de Salários + Encargos:</strong><br> <?= 'R$ ' . number_format( $model->planp_totalsalarioencargo, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="3"><strong>Diárias: </strong><br> <?= 'R$ ' . number_format($model->planp_diarias, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Passagens: </strong><br> <?= 'R$ ' . number_format( $model->planp_passagens, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Serv. Terceiros (PF): </strong><br> <?= 'R$ ' . number_format( $model->planp_pessoafisica, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Serv. Terceiros (PJ): </strong><br> <?= 'R$ ' . number_format( $model->planp_pessoajuridica, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="3"><strong>Mat. Didático (Apostila): </strong><br> <?= 'R$ ' .  number_format($model->planp_PJApostila, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Mat. Didático (Livros): </strong><br> <?= 'R$ ' .  number_format($model->planp_custosmateriais, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Material Consumo: </strong><br> <?= 'R$ ' .  number_format($model->planp_custosconsumo, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Total de Custo Direto: </strong><br> <?= 'R$ ' . number_format( $model->planp_totalcustodireto, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="12"><strong>Valor Hora/Aula de Custo Direto: </strong><br> <?= 'R$ ' . number_format( $model->planp_totalhoraaulacustodireto, 2, ',', '.'); ?></td>
        </tr>
    </tbody>
   </table>

   <table class="table table-condensed table-hover">
    <thead>
    <tr class="info"><th colspan="12">SEÇÃO 3: Cálculos de Custos Indiretos</th></tr>
    </thead>
    <tbody>
        <tr>
            <td style="font-size:11px;" colspan="3"><strong>Custos Indiretos(%): </strong><br> <?= number_format($model->planp_custosindiretos, 2, ',', '.') . '%'; ?></td>
            <td style="font-size:11px;" colspan="3"><strong>IPCA/Mês(%): </strong><br> <?= number_format($model->planp_ipca, 2, ',', '.') . '%'; ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Rerserva Técnica(%): </strong><br> <?= number_format($model->planp_reservatecnica, 2, ',', '.') . '%'; ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Despesa Sede ADM(%): </strong><br> <?= number_format($model->planp_despesadm, 2, ',', '.') . '%'; ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="4"><strong>Total Incidências(%): </strong><br> <?= number_format($model->planp_totalincidencias, 2, ',', '.') . '%'; ?></td>
            <td style="font-size:11px;" colspan="4"><strong>Total Custo Indireto: </strong><br> <?= 'R$ ' . number_format( $model->planp_totalcustoindireto, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="4"><strong>Despesa Total: </strong><br> <?= 'R$ ' . number_format( $model->planp_despesatotal, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="4"><strong>Mark-Up Divisor 100-X/100: </strong><br> <?= number_format($model->planp_markdivisor, 2, ',', '.') . '%'; ?></td>
            <td style="font-size:11px;" colspan="4"><strong>Mark-Up Multiplicador 100/Markup: </strong><br> <?= number_format($model->planp_markmultiplicador, 2, ',', '.') . '%'; ?></td>
            <td style="font-size:11px;" colspan="4"><strong>Valor Hora/Aula por Aluno: </strong><br> <?= 'R$ ' . number_format( $model->planp_horaaulaaluno, 2, ',', '.'); ?></td>
        </tr>
        <tr>
            <td style="font-size:11px;" colspan="3"><strong>Preço de Venda pela planilha: </strong><br> <?= 'R$ ' . number_format( $model->planp_vendaaluno, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>Retorno com Preço de Venda: </strong><br> <?= 'R$ ' . number_format( $model->planp_retorno, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="4"><strong>Preço de Venda Total da Turma: </strong><br> <?= 'R$ ' . number_format( $model->planp_vendaturma, 2, ',', '.'); ?></td>
            <td style="font-size:11px;" colspan="3"><strong>% de Retorno: </strong><br> <?= number_format($model->planp_porcentretorno, 2, ',', '.') . '%'; ?></td>
        </tr>
        </tr>
    </tbody>
   </table>


    <table class="table table-condensed" cellpadding=12 cellspacing=12 >
    <tbody>
        <tr>
            <td style="font-size:11px; text-align: center; background-color: #FFE0B2; padding:1%" colspan="6"><b>Capital</b></td>
            <table class="table table-condensed">
                <tbody>
                    <tr>
                        <!-- Capital -->
                        <td style="font-size:10px;"><b>Preço de Venda:</b><br> <?= 'R$ ' . number_format( $model->planp_precosugerido, 2, ',', '.'); ?></td>
                        <td style="font-size:10px;"><b>Retorno R$:</b><br> <?= 'R$ ' . number_format( $model->planp_retornoprecosugerido, 2, ',', '.'); ?></td>
                        <td style="font-size:10px;"><b>Valor Total:</b><br> <?= 'R$ ' . number_format( $model->planp_vendaturmasugerido, 2, ',', '.'); ?></td>
                        <td style="font-size:10px;"><b>% de Retorno:</b><br> <?= number_format($model->planp_porcentretornosugerido, 2, ',', '.') . '%'; ?></td>
                    </tr>
                    <tr>
                        <!-- Capital -->
                        <td style="font-size:10px;"><b>Parcelas:</b><br> <?= $model->planp_parcelas; ?></td>
                        <td style="font-size:10px;"><b>Valor das Parcelas:</b><br> <?= 'R$ ' . number_format( $model->planp_valorparcelas, 2, ',', '.'); ?></td>
                        <td style="font-size:10px;" colspan="2"><b>Mínimo de Alunos:</b><br> <?= $model->planp_minimoaluno; ?></td>
                    </tr>
                </tbody>
            </table>


            <td style="font-size:11px; text-align: center; background-color: #FFE0B2; padding:1%" colspan="6"><b>Municípios do Interior</b></td>
            <table class="table table-condensed">
                <tbody>
                    <tr>
                        <!-- Interior -->
                        <td style="font-size:10px;"><b>Preço de Venda:</b><br> <?= 'R$ ' . number_format( $model->planp_valorcomdesconto, 2, ',', '.'); ?></td>
                        <td style="font-size:10px;"><b>Retorno R$:</b><br> <?= 'R$ ' . number_format( $model->planp_retornoprecosugeridointerior, 2, ',', '.'); ?></td>
                        <td style="font-size:10px;"><b>Valor Total:</b><br> <?= 'R$ ' . number_format( $model->planp_vendaturmasugeridointerior, 2, ',', '.'); ?></td>
                        <td style="font-size:10px;"><b>% de Retorno:</b><br> <?= number_format($model->planp_porcentretornosugeridointerior, 2, ',', '.') . '%'; ?></td>
                    </tr>
                    <tr>
                        <!-- Interior -->
                        <td style="font-size:10px;"><b>Desconto:</b><br> <?= $model->planp_desconto . '%'; ?></td>
                        <td style="font-size:10px;"><b>Valor das Parcelas:</b><br> <?= 'R$ ' . number_format( $model->planp_valorparcelasinterior, 2, ',', '.'); ?></td>
                        <td style="font-size:10px;" colspan="2"><b>Mínimo de Alunos:</b><br> <?= $model->planp_minimoalunointerior; ?></td>
                    </tr>
                </tbody>
            </table>
        </tr>
    </tbody>
    </table>

   <table class="table table-condensed table-hover">
    <thead>
    <tr class="info"><th colspan="12">SEÇÃO 4: Auditoria</th></tr>
    </thead>
    <tbody>
        <tr>
            <td style="font-size:11px;" colspan="6"><strong>Cadastrado por: </strong><br> <?= $model->colaborador->usuario->usu_nomeusuario ?></td>
            <td style="font-size:11px;" colspan="6"><strong>Data de Cadastro: </strong><br> <?= date('d/m/Y', strtotime($model->planp_data)) ?></td>
        </tr>

        <?php if(isset($model->planp_codcolaboradoratualizacao)) : ?>
        <tr>
            <td style="font-size:11px;" colspan="6"><strong>Atualizado por: </strong><br> <?= $model->colaborador->usuario->usu_nomeusuario ?></td>
            <td style="font-size:11px;" colspan="6"><strong>Data de Atualização: </strong><br> <?= date('d/m/Y', strtotime($model->planp_dataatualizacao)) ?></td>
        </tr>
        <?php endif; ?>
    </tbody>
   </table>

        </div>
    </div>
</div><br><br><br><br><br>

<div class="panel panel-primary">
    <div class="panel-body">
          <div class="row">

            <div class="panel-body">

               <?= $this->render('view-unidades', [
                                    'model' => $model,
                        ]) ?>

            </div>
        </div>
    </div>
</div>
