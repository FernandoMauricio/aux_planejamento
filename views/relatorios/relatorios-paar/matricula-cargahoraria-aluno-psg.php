<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\cadastros\Ano;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Situacaoplanilha;
use app\models\planilhas\Planilhadecurso;

?>
		   <table width="100%" border="0">
           <tr> 
           <td width="21%"><img src="<?php echo Url::base().'/uploads/logo.png' ?>" height="100px"></td>
           <td width="11%" align="left" valign="middle"> <p><br>
           <font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>Módulo: 
           </strong><strong><br>
           Relatório: </strong></font><br>
           <br>
           </p></td>
           <td width="41%" align="left" valign="middle"><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Auxílio 
           ao Planejamento<strong><br>
           </strong>Matricula e Carga Horária - PSG/Não PSG</font></td>
           <td width="27%" align="right" valign="bottom"><em></em></td>
           </tr>
           <tr> 
           <td colspan="4"><hr align="left" width="70%"></td>
           </tr>
           <tr> 
           <td colspan="4"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">CRITÉRIOS 
           DO RELATÓRIO</font></td>
           </tr>
           <tr> 
           <td colspan="4"><table width="100%" border="0">
           <tr> 
           <td width="4%">&nbsp;</td>
           <td width="9%" valign="middle"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">UNIDADE</font></strong></td>
           <td colspan="3" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Todas</font></td>
           </tr>
           <tr> 
           <td>&nbsp;</td>
           <td valign="middle"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ORÇAMENTO</font></strong></td>
           <td width="12%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $ano_orcamento['an_ano'];?></font></td>
           <td width="13%" valign="middle"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>SITUAÇÃO</strong></font></td>
           <td width="62%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $situacao_planilha['sipla_descricao'];?></font></td>
           </tr>
           <tr> 
           <td>&nbsp;</td>
           <td valign="middle"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">TIPO</font></strong></td>
           <td colspan="3" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $tipo_planilha['tipla_descricao'];?></font></td>
           </tr>
           <tr> 
           <td>&nbsp;</td>
           <td valign="middle"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PROGRAMAÇÃO</font></strong></td>
           <td width="3%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $tipo_programacao['tipro_descricao'];?></font></td>
           </tr>
           </table></td>
           </tr>
           <tr>
           <td colspan="4"><hr align="right" width="70%"></td>
           </tr>
           </table>
		   <BR>

<section class="signa-table-section clearfix">
<div class="container">
    <div class="row">
        <div class="col-lg">
            <table class="table table-responsive table-bordered table-hover">
                <thead>
                    <tr>
                        <th rowspan="3" style="vertical-align : middle;text-align:center;">UNIDADES</th>
                        <th colspan="2" style="text-align: center;">PSG</th>
                        <th colspan="2" style="text-align: center;">NÃO PSG</th>
                        <th style="vertical-align : middle;text-align:center;">ISENTOS</th>
                        <!-- <th rowspan="3" style="vertical-align : middle;text-align:center;">TOTAL</th> -->
                    </tr>
                    <tr>
                        <th style="text-align: center;">Matriculas</th>
                        <th style="text-align: center;">Carga Horária</th>
                        <th style="text-align: center;">Matriculas</th>
                        <th style="text-align: center;">Carga Horária</th>
                        <th style="text-align: center;">Matriculas</th>
                    </tr>
               </thead>

               <!-- <thead>
                    <tr>
                        <th rowspan="3" style="vertical-align : middle;text-align:center;">UNIDADES</th>
                        <th colspan="4" style="vertical-align : middle;text-align:center;">TURMAS MISTAS</th>
                    </tr>
                    <tr>
                        <th colspan="2" style="text-align: center;">PSG</th>
                        <th colspan="2" style="text-align: center;">NÃO PSG</th>
                        <th style="vertical-align : middle;text-align:center;">ISENTOS</th>
                        <th rowspan="3" style="vertical-align : middle;text-align:center;">TOTAL</th>
                    </tr>
                    <tr>
                        <th style="text-align: center;">Matriculas</th>
                        <th style="text-align: center;">Carga Horária</th>
                        <th style="text-align: center;">Matriculas</th>
                        <th style="text-align: center;">Carga Horária</th>
                        <th style="text-align: center;">Matriculas</th>
                    </tr>
               </thead> -->
        <?php
		   $total_geral = 0;
		   $quantidade_educacao_profissional_geral = 0;
           $quantidade_acao_extensiva_geral = 0;
		   $quantidade_acao_extensiva = 0;
           $soma_matricula_psg = 0;
           $soma_cargahoraria_psg = 0;
           $soma_matricula = 0;
           $soma_cargahoraria = 0;
           $somaTotalAlunos = 0;
           $somaIsentos = 0;
           $somaTotalCargaHoraria = 0;
		   
		    //EXTRAINDO AS UNIDADES DAS PLANILHAS....
		    $query_unidades = "SELECT placu_nomeunidade,placu_codunidade FROM planilhadecurso_placu  WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' group by placu_codunidade order by placu_nomeunidade";
		    $unidades = Planilhadecurso::findBySql($query_unidades)->all(); 

            foreach ($unidades as $unidade) {
		        $codigo_unidade  = $unidade['placu_codunidade'];
			    $nome_unidade    = $unidade['placu_nomeunidade'];
				  
			//EXRAINDO AS INFORMAÇÕES DAS PLANILHAS...
			$query_planilhas = "SELECT placu_codeixo,placu_codcategoria, placu_quantidadeturmas,placu_quantidadealunos,placu_quantidadealunosisentos,placu_quantidadealunospsg, placu_cargahorariaarealizar FROM planilhadecurso_placu WHERE placu_codunidade = '".$codigo_unidade."' AND placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."'";
            $planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

            foreach ($planilhas as $planilha) {
			    $codigo_eixo               = $planilha['placu_codeixo'];
			    $quantidade_turmas         = $planilha['placu_quantidadeturmas'];
			    $quantidade_alunos         = $planilha['placu_quantidadealunos'];
			    $quantidade_alunos_psg     = $planilha['placu_quantidadealunospsg'];
			    $quantidade_alunos_isentos = $planilha['placu_quantidadealunosisentos'];
                $carga_horariaarealizar    = $planilha['placu_cargahorariaarealizar'];
                $carga_horariavivencia     = $planilha['placu_cargahorariavivencia'];
                $placu_codcategoria        = $planilha['placu_codcategoria'];
            
                //Matriculas PSG
                if($placu_codcategoria == 2 || $placu_codcategoria == 3) {
                    $soma_matricula_psg       += $quantidade_alunos_psg * $quantidade_turmas;
                    $soma_cargahoraria_psg    += $carga_horariaarealizar * $quantidade_turmas;
                }

                //Matriculas Não PSG
                if($placu_codcategoria == 1) {
                    $soma_cargahoraria += $carga_horariaarealizar * $quantidade_turmas;
                    $soma_matricula    += $quantidade_alunos * $quantidade_turmas;
                }

                //Isentos
                $somaIsentos += $quantidade_alunos_isentos * $quantidade_turmas;

                //Totais
                $somaTotalAlunos += ($quantidade_alunos_psg + $quantidade_alunos + $quantidade_alunos_isentos) * $quantidade_turmas;
                $somaTotalCargaHoraria += $carga_horariaarealizar * $quantidade_turmas;

			    }//FIM DAS PLANILHAS

		?>
        <tbody>
            <tr>
                <td><?= $nome_unidade ?></td>
                <td><?= $soma_matricula_psg ?></td>
                <td><?= $soma_cargahoraria_psg ?></td>
                <td><?= $soma_matricula ?></td>
                <td><?= $soma_cargahoraria ?></td>
                <td><?= $somaIsentos ?></td>
                <!-- <td><b><?= $somaTotalAlunos ?> </b></td>
                <td><b><?= $somaTotalCargaHoraria ?> </b></td> -->
            </tr>
        </tbody>

        <?php } // FIM DAS UNIDADES ?>

</table>
        </div>
    </div>
</div>
</section>
