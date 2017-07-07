<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\cadastros\Ano;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Situacaoplanilha;
use app\models\cadastros\Eixo;
use app\models\cadastros\Tipo;
use app\models\planilhas\Planilhadecurso;
?>

		   <table width="100%" border="0">
           <tr> 
           <td width="21%"><img src="<?php echo Url::base().'/uploads/logo.png' ?>" height="100px"></td>
           <td width="11%" align="left" valign="middle"> <p><br>
           <font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>M&oacute;dulo: 
           </strong><strong><br>
           Relat&oacute;rio: </strong></font><br>
           <br>
           </p></td>
           <td width="41%" align="left" valign="middle"><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Aux&iacute;lio 
           ao Planejamento<strong><br>
           </strong> Receita x Despesa por Unidade</font></td>
           <td width="27%" align="right" valign="bottom"><em></em></td>
           </tr>
           <tr> 
           <td colspan="4"><hr align="left" width="70%"></td>
           </tr>
           <tr> 
           <td colspan="4"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">CRIT&Eacute;RIOS 
           DO RELAT&Oacute;RIO</font></td>
           </tr>
           <tr> 
           <td colspan="4"><table width="100%" border="0">
           <tr> 
           <td width="4%">&nbsp;</td>
           <td width="9%" valign="middle"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">UNIDADE</font></strong></td>
           <td colspan="3" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Todas as Unidades</font></td>
           </tr>
           <tr> 
           <td>&nbsp;</td>
           <td valign="middle"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ORÇAMENTO</font></strong></td>
           <td width="12%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $ano_orcamento['an_ano'];?></font></td>
           <td width="13%" valign="middle"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>SITUA&Ccedil;&Atilde;O</strong></font></td>
           <td width="62%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $situacao_planilha['sipla_descricao'];?></font></td>
           </tr>
           <tr> 
           <td>&nbsp;</td>
           <td valign="middle"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">TIPO</font></strong></td>
           <td colspan="3" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $tipo_planilha['tipla_descricao'];?></font></td>
           </tr>
           </table></td>
           </tr>
           <tr>
           <td colspan="4"><hr align="right" width="70%"></td>
           </tr>
           </table>
           <br>
		   
		   
		   <table width="100%" border="1" cellspacing="0" bordercolor="#000000">
           <tr valign="middle"> 
           <td width="62%" bgcolor="#CACACA"> 
           <div align="center"><strong><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">UNIDADES</font></strong></font></strong></div></td>
           <td width="20%" bgcolor="#CACACA"> 
           <div align="center"><strong><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">RECEITA</font></strong></font></strong></div></td>
           <td width="18%" bgcolor="#CACACA"> 
           <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">DESPESA</font></strong></div></td>
           </tr>
				   
		<?php
		   $valor_receita_geral = 0;
		   $valor_despesa_geral = 0;

		   //EXTRAINDO AS UNIDADES DAS PLANILHAS....
		    $query_unidades = "SELECT placu_nomeunidade,placu_codunidade FROM planilhadecurso_placu  WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' group by placu_codunidade order by placu_nomeunidade";

		    $unidades = Planilhadecurso::findBySql($query_unidades)->all(); 

            foreach ($unidades as $unidade) {

		        $codigo_unidade  = $unidade['placu_codunidade'];
			      $nome_unidade    = $unidade['placu_nomeunidade'];
				  
				  $quantidade_educacao_profissional = 0;
				  $quantidade_acao_extensiva = 0;
				  $subtotal_unidade = 0;
				  $valor_receita = 0;
				  $valor_despesa = 0;

				//EXRAINDO AS INFORMAÇÕES DAS PLANILHAS...
				$query_planilhas = "SELECT placu_codeixo,placu_quantidadeturmas,placu_quantidadealunos,placu_quantidadealunosisentos,placu_quantidadealunospsg, placu_cargahorariaarealizar, placu_valorparcelas, placu_totalcustodireto, placu_totalcustoindireto FROM planilhadecurso_placu WHERE placu_codunidade = '".$codigo_unidade."' AND placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."'";
        		$planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

            foreach ($planilhas as $planilha) {

					   $placu_codplanilha         = $planilha['placu_codplanilha'];
					   $codigo_eixo               = $planilha['placu_codeixo'];
					   $carga_horaria_turma       = $planilha['placu_cargahorariaarealizar'];
					   $quantidade_turmas         = $planilha['placu_quantidadeturmas'];
						 $quantidade_alunos         = $planilha['placu_quantidadealunos'];
						 $quantidade_alunos_psg     = $planilha['placu_quantidadealunospsg'];
						 $quantidade_alunos_isentos = $planilha['placu_quantidadealunosisentos'];
						 $valor_mensalidade         = $planilha['placu_valorparcelas'];
						 $valor_total_direta        = $planilha['placu_totalcustodireto'];
						 $valor_total_indireto      = $planilha['placu_totalcustoindireto'];
						 $quantidade_parcelas       = $planilha['placu_parcelas'];
																										  
								$carga_horaria_total_turma    = $carga_horaria_turma * $quantidade_turmas;
								$matriculas_total_turma       = ($quantidade_alunos + $quantidade_alunos_psg + $quantidade_alunos_isentos) * $quantidade_turmas;
										  
								$receita_prevista_aluno       = $valor_mensalidade;
								$receita_prevista_total_aluno = $receita_prevista_aluno * ($quantidade_alunos * $quantidade_turmas);
								
								$valor_receita                = $valor_receita + $receita_prevista_total_aluno;
								$valor_receita_geral          = $valor_receita_geral + $receita_prevista_total_aluno;	  
												  
								//VAI SER PEGO OS VALORES DE CADA TIPO DE DESPESA PARA CALCULAR O CUSTO TOTAL DA PLANILHA....
								$carga_horaria_total = 0;
			                    $valor_total_docente = 0;
                                $encargos_calcular_docente = 0;
                                $encargos_total_docente = 0;


				//DESPESAS COM DOCENTE...
				$query_desoesasDocentes = "SELECT planides_encargos, planides_valorhoraaula, planides_cargahoraria FROM planilhadespesadoce_planides WHERE planilhadecurso_cod = '".$placu_codplanilha."' ";
        		$despesasDocente = Planilhadecurso::findBySql($query_desoesasDocentes)->all(); 

            foreach ($despesasDocente as $despesaDocente) {

            				$encargos      = $planilha['planides_encargos'];
            				$valor         = $planilha['planides_valorhoraaula'];
            				$carga_horaria = $planilha['planides_cargahoraria'];
					
                                        $carga_horaria_total = $carga_horaria_total + $carga_horaria;
                                       	$valor_calcular = $valor * $carga_horaria;
                                       	$valor_total_docente = $valor_total_docente + $valor_calcular;				
                                        $encargos_calcular_docente = ( $encargos * $valor_calcular ) / 100 ;
                                        $encargos_total_docente = $encargos_total_docente + $encargos_calcular_docente;
						      }
														
								 $valor_total_indireto = 0;
														
								//CALCULANDO O CUSTO TOTAL DA PLANILHA...
								$custo_planilha = $valor_total_docente + $encargos_total_docente + $valor_total_direta + $valor_total_indireto ;
							   	$inadimplencia_3 = 0;
								if($quantidade_parcelas > 1)
							    {
								      $inadimplencia_3 = ($custo_planilha * 3) / 100;
									  $custo_planilha = $custo_planilha + $inadimplencia_3;
								  }
														
								$custo_total_planilha = $custo_planilha * $quantidade_turmas;
								
								$valor_despesa = $valor_despesa + $custo_total_planilha;
								$valor_despesa_geral = $valor_despesa_geral + $custo_total_planilha;
								$custo_total_planilha = 0;
					 	}				         
					 ?>									
					 <tr valign="middle"> 
                     <td bgcolor="#EEEEEE"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $nome_unidade; ?></font></td>
                     <td bgcolor="#EEEEEE"> <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo number_format($valor_receita,2,".",".");?></font></font></font></font></div></td>
                     <td bgcolor="#EEEEEE"> <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo number_format($valor_despesa,2,".",".");?></font></font></font></font></div></td>
                     </tr>
                     <?php
					 $valor_despesa = 0;
						} // FIM DAS UNIDADES
		    		?>
            <tr valign="middle"> 
            <td bgcolor="#CACACA">
            <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em><strong>TOTAL</strong></em></font></div></td>
            <td bgcolor="#EEEEEE"> <div align="right"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($valor_receita_geral,2,".","."); ?></font></font></div></td>
            <td bgcolor="#EEEEEE"> <div align="right"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo number_format($valor_despesa_geral,2,".","."); ?></font></font></font></font><font size="2"></font></div></td>
            </tr>
            </table>
			<br>

          <br>
          <table width="100%" border="0">
          <tr>
          <td><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Gerado 
          em: <?php echo date("d/m/Y"); ?> &agrave;s <?php echo date("H:i:s");?></font></div></td>
          </tr>
          </table>
