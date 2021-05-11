<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\base\Unidade;
use app\models\cadastros\Ano;
use app\models\cadastros\Nivel;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Situacaoplanilha;
use app\models\cadastros\Eixo;
use app\models\cadastros\Segmento;
use app\models\cadastros\Tipo;
use app\models\planos\Planodeacao;
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
           </strong>Relatório Geral - Modelo I</font></td>
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
           <td colspan="3" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $combounidade['placu_codunidade'] == 0 ? "Todas as Unidades" : $combounidade['placu_nomeunidade'];?></font></td>
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
           </table></td>
           </tr>
           <tr>
           <td colspan="4"><hr align="right" width="70%"></td>
           </tr>
           </table>
           <br>
		   		   
		<?php
		   
		   $valor_hora_aluno_total_geral = 0;  
		   
		   $quantidade_turmas_educacao_profissional_geral = 0;
		   $quantidade_turmas_acao_extensivas_geral = 0;
				 
		   $quantidade_matriculas_educacao_profissional_geral = 0;
		   $quantidade_matriculas_acao_extensivas_geral = 0;
					 
		   $carga_horaria_educacao_profissional_geral = 0;
		   $carga_horaria_acao_extensivas_geral = 0;
					 
		   $receita_prevista_educacao_profissional_geral = 0;
		   $receita_prevista_acao_extensivas_geral = 0;
					 
		   $despesa_prevista_educacao_profissional_geral = 0;
		   $despesa_prevista_acao_extensivas_geral = 0;
		   
		   //EXTRAINDO AS UNIDADES CONFORME CRITÉRIO....
		   if($combounidade['placu_codunidade'] == 0)//TODAS...
		    { 
		     	   $query_unidades = "SELECT placu_nomeunidade, placu_codunidade FROM `db_apl2`.`planilhadecurso_placu` WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' GROUP BY placu_codunidade ORDER BY placu_nomeunidade";
            } else //UMA UNIDADE EM ESPECÍFICO...
		           $query_unidades = "SELECT placu_nomeunidade,placu_codunidade FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$combounidade['placu_codunidade']."' GROUP BY placu_codunidade ORDER BY placu_nomeunidade";
		   
		   	    $unidades = Planilhadecurso::findBySql($query_unidades)->all(); 

            	foreach ($unidades as $unidade) {
            		$codigo_unidade = $unidade['placu_codunidade'];
            		$nome_unidade   = $unidade['placu_nomeunidade'];

					$quantidade_turmas_educacao_profissional = 0;
					$quantidade_turmas_acao_extensivas = 0;
					
					$quantidade_matriculas_educacao_profissional = 0;
					$quantidade_matriculas_acao_extensivas = 0;
					
					$carga_horaria_educacao_profissional = 0;
					$carga_horaria_acao_extensivas = 0;
					
					$receita_prevista_educacao_profissional = 0;
					$receita_prevista_acao_extensivas = 0;
					
					$despesa_prevista_educacao_profissional = 0;
					$despesa_prevista_acao_extensivas = 0;
					
					$hora_aluno_total_unidade = 0;
				
		?>
				
			         <table width="100%" border="0">
                     <tr> 
                     <td valign="middle" bgcolor="#E0E0E0"><font size="2" face="Arial, Helvetica, sans-serif"><em><?php echo $nome_unidade; ?></em></font></td>
                     </tr>
                     </table>
				     	     	
				     <?php
					 
					 
					 //EXTRAINDO OS EIXOS DAS PLANILHAS CONFORME A UNIDADE ACIMA...
					 $query_eixos = "SELECT eix_descricao, eix_codeixo FROM eixo_eix, planilhadecurso_placu WHERE placu_codunidade = '".$codigo_unidade."' AND placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codeixo = eix_codeixo GROUP BY placu_codeixo ORDER BY eix_descricao";
					    $eixos = Eixo::findBySql($query_eixos)->all(); 

			           foreach ($eixos as $eixo) {

			           	$codigo_eixo = $eixo['eix_codeixo'];
			           	$nome_eixo   = $eixo['eix_descricao'];
						  
						      ?>
						  
						      <table width="100%" border="0">
                              <tr> 
                              <td width="7%" valign="middle">&nbsp;</td>
                              <td width="93%" valign="middle" bgcolor="#E0E0E0"><font size="2" face="Arial, Helvetica, sans-serif"><em><?php echo $nome_eixo; ?></em></font></td>
                              </tr>
                              </table>
						  
						      <?php
							  
							   //EXTRAINDO OS EIXOS DAS PLANILHAS CONFORME A UNIDADE ACIMA...
					           $query_segmentos = "SELECT seg_descricao, seg_codsegmento FROM segmento_seg, planilhadecurso_placu WHERE placu_codunidade = '".$codigo_unidade."' AND placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codeixo = '".$codigo_eixo."' AND placu_codsegmento = seg_codsegmento GROUP BY placu_codsegmento ORDER BY seg_descricao";
						          $segmentos = Segmento::findBySql($query_segmentos)->all(); 

						              foreach ($segmentos as $segmento) {

						              $codigo_segmento  = $segmento['seg_codsegmento'];
						              $nome_segmento    = $segmento['seg_descricao'];
									  
									  ?>
									   
									   <table width="100%" border="0">
                                       <tr> 
                                       <td width="12%" valign="middle">&nbsp;</td>
                                       <td width="88%" valign="middle" bgcolor="#E0E0E0"><font size="2" face="Arial, Helvetica, sans-serif"><em><?php echo $nome_segmento; ?></em></font></td>
                                       </tr>
                                       </table>
									 
									  <?php
									  
									  $query_tipos = "SELECT tip_descricao, tip_codtipoa FROM tipodeacao_tip, planilhadecurso_placu WHERE placu_codunidade = '".$codigo_unidade."' AND placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codeixo = '".$codigo_eixo."' AND placu_codsegmento = '".$codigo_segmento."' AND placu_codtipoa = tip_codtipoa GROUP BY placu_codtipoa ORDER BY tip_descricao";
									   	    $tipos = Tipo::findBySql($query_tipos)->all(); 

							            	foreach ($tipos as $tipo) {
							            		$codigo_tipodeacao  = $tipo['tip_codtipoa'];
										        $nome_tipodeacao    = $tipo['tip_descricao'];
											 
											  $hora_aluno_unidade = 0;
											 
											 ?>
											 
											 <table width="100%" border="0">
                                             <tr> 
                                             <td width="18%" valign="middle">&nbsp;</td>
                                             <td width="82%" valign="middle" bgcolor="#E0E0E0"><font size="2" face="Arial, Helvetica, sans-serif"><em><?php echo $nome_tipodeacao; ?></em></font></td>
                                             </tr>
                                             </table>
											 <br>
												 
<table width="100%" border="1" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td rowspan ="2" width="30%"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Plano</font></strong></div></td>
    <td rowspan ="2"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Nível</font></strong></div></td>
    <td rowspan ="2" width="20%"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Novo Modelo Pedagógico</font></strong></div></td>
    <td rowspan ="2"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Início Turma</font></strong></div></td>
    <td width="15%" colspan="3"><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">TURMAS</font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">CARGA 
        HORÁRIAS</font></strong></div></td>
    <td colspan="4"><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">MATRÍCULAS</font></strong></div></td>
    <td colspan="2"><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">RECEITA 
        PREV. </font></strong></div></td>
    <td colspan="2"><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">DESPESA</font></strong></div></td>
    <td rowspan ="2"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Retorno %</font></strong></div></td>
  </tr>
  <tr valign="middle"> 
    <td> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Presencial</font></strong></div></td>
    <td> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">EAD</font></strong></div></td>
    <td> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Remoto</font></strong></div></td>
    <td width="6%"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Uma Turma</font></strong></div></td>
    <td width="4%"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">CHT</font></strong></div></td>
    <td width="5%"><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">CHA</font></strong></div></td>
    <td width="5%"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PAG</font></strong></div></td>
    <td width="4%"><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PSG</font></strong></div></td>
    <td width="4%"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ISE</font></strong></div></td>
    <td width="7%"><div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Total</font></strong></div></td>
    <td width="8%"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Aluno</font></strong></div></td>
    <td width="8%"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Total</font></strong></div></td>
    <td width="8%"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Turma</font></strong></div></td>
    <td width="9%"> <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Total</font></strong></div></td>
    
  </tr>
  			<?php
				 
				 $quantidade_turmas_tipoacao = 0;
				 $cargahoraria_turmas_tipoacao = 0;
				 $matriculas_turmas_tipoacao = 0;
				 $receita_turmas_tipoacao = 0;
				 $despesa_turmas_tipoacao = 0;
         $quantidade_turmas_ead = 0;
         $quantidade_turmas_remoto = 0;
				 
				 //EXTRAINDO AS PLANILHAS E SUAS INFORMAÇÕES...
				 $query_planilhas = "SELECT placu_codplanilha, placu_ead, placu_remoto, plan_descricao, plan_modelonacional, niv_sigla, placu_quantidadeturmas,placu_quantidadealunosisentos, placu_cargahorariavivencia, placu_cargahorariaarealizar,placu_quantidadealunos, placu_quantidadealunospsg,placu_precosugerido, placu_despesatotal, placu_porcentprecosugerido, placu_codnivel, placu_codplano, placu_codano, placu_anoexercicio FROM planodeacao_plan, planilhadecurso_placu, nivel_niv WHERE placu_codunidade = '".$codigo_unidade."' AND placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codeixo = '".$codigo_eixo."' AND placu_codsegmento = '".$codigo_segmento."' AND placu_codtipoa = '".$codigo_tipodeacao."' AND placu_codplano = plan_codplano AND placu_codnivel = niv_codnivel AND placu_codprogramacao = '".$combotipoprogramacao['tipro_codprogramacao']."'  ORDER BY plan_descricao";
			     	$planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 
						         foreach ($planilhas as $planilha) {
			          $codigo_planilha  			      = $planilha['placu_codplanilha'];
			          $nome_plano  				          = $planilha['plano']['plan_descricao'];
                $modeloPedagogico  				    = $planilha['plano']['plan_modelonacional'];
			         	$quantidade_turmas  		      = $planilha['placu_quantidadeturmas'];
			         	$carga_horaria_turma 	        = $planilha['placu_cargahorariaarealizar'];
			         	$carga_horaria_vivencia       = $planilha['placu_cargahorariavivencia'];
			         	$quantidade_alunos  	        = $planilha['placu_quantidadealunos'];
			         	$quantidade_alunos_psg        = $planilha['placu_quantidadealunospsg'];
			         	$valor_mensalidade  	        = $planilha['placu_precosugerido'];
			         	$sigla_nivel  		            = $planilha['nivel']['niv_sigla'];
			         	$quantidade_alunos_isentos    = $planilha['placu_quantidadealunosisentos'];
			         	$carga_hora_para_aluno        = $planilha['placu_cargahorariaarealizar'];
			         	$quantidade_turmas_para_aluno = $planilha['placu_quantidadeturmas'];
			         	$placu_anoexercicio           = $planilha['placu_anoexercicio'];
			         	$placu_codano                 = $planilha['planilhaAno']['an_ano'];
                $placu_ead                    = $planilha['placu_ead'];
                $placu_remoto                 = $planilha['placu_remoto'];
                  
                  

			         	 $custo_planilha               = $planilha['placu_despesatotal'];
			         	 $placu_porcentprecosugerido   = $planilha['placu_porcentprecosugerido'];


			         	 //Cálculos Realizados
						  $carga_horaria_planilha       = $carga_horaria_vivencia + $carga_horaria_turma;
						  $carga_horaria_total_turma    = $carga_horaria_turma * $quantidade_turmas;
						  $matriculas_total_turma       = ( $quantidade_alunos + $quantidade_alunos_psg + $quantidade_alunos_isentos ) * $quantidade_turmas;
						  $receita_prevista_aluno 		  = $valor_mensalidade;
						  $receita_prevista_total_aluno = $receita_prevista_aluno *  ( $quantidade_alunos * $quantidade_turmas );
						  $custo_total_planilha         = $custo_planilha * $quantidade_turmas;
                           
							$cor = "#006633";
						     
						     if($placu_porcentprecosugerido < 0 && $placu_porcentprecosugerido >= -15)
			                        
			                        $cor = "#FF0000";
			                 elseif($placu_porcentprecosugerido < -15 && $placu_porcentprecosugerido >= -25)
			                        
			                        $cor = "#FF0000";
			                 elseif($placu_porcentprecosugerido < -25 && $placu_porcentprecosugerido >= -35)
			                        
			                        $cor = "#FF0000";
			                 elseif($placu_porcentprecosugerido < -35 && $placu_porcentprecosugerido >= -45)
			                        
			                        $cor = "#FF0000";
			                 elseif($placu_porcentprecosugerido < -45 && $placu_porcentprecosugerido >= -55)
			                       
			                        $cor = "#FF0000";
			                 elseif($placu_porcentprecosugerido < -55 && $placu_porcentprecosugerido >= -65)
			                       
			                       $cor = "#FF0000";
			                 elseif($placu_porcentprecosugerido < -65 && $placu_porcentprecosugerido >= -75)
			                       
			                       $cor = "#FF0000";
			                 elseif($placu_porcentprecosugerido < -75 && $placu_porcentprecosugerido >= -85)
			                       
			                       $cor = "#FF0000";
			                 elseif($placu_porcentprecosugerido < -85 && $placu_porcentprecosugerido >= -96)
			                        
			                       $cor = "#FF0000";
			                 elseif($placu_porcentprecosugerido < -96)
			                        
			                       $cor = "#FF0000";
								  
							$calculo1 = ($carga_hora_para_aluno + $carga_horaria_vivencia) * ($quantidade_alunos + $quantidade_alunos_psg + $quantidade_alunos_isentos);
			                $calculo1 = $calculo1 * $quantidade_turmas_para_aluno;
			?>
  <tr valign="middle"> 
    <td><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $nome_plano; ?></font></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $sigla_nivel; ?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $modeloPedagogico; ?></font></font></font></font></div></td>
	<td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $placu_anoexercicio; ?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $quantidade_turmas; ?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $placu_ead; ?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $placu_remoto; ?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $carga_horaria_planilha; ?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"> 
        <?php  echo number_format($carga_horaria_planilha * $quantidade_turmas, 0, ',', '.'); ?>
        </font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2">
      <?php  echo number_format($calculo1, 0, ',', '.'); ?>
    </font></font></font></font></div></td>
    <td> <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $quantidade_alunos; ?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $quantidade_alunos_psg; ?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $quantidade_alunos_isentos; ?></font></font></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo $matriculas_total_turma; ?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo number_format($receita_prevista_aluno, 2, ',', '.');?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo number_format($receita_prevista_total_aluno, 2, ',', '.');?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo number_format($custo_planilha, 2, ',', '.');?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><?php echo number_format($custo_total_planilha, 2, ',', '.');?></font></font></font></font></div></td>
    <td><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><font size="2" color="<?php echo $cor; ?>"><?php echo number_format($placu_porcentprecosugerido, 2, ',', '.'); ?></font></font></font></font></div></td>
  </tr>
  			<?php
						  
						      $quantidade_turmas_tipoacao   += $quantidade_turmas;
                  $quantidade_turmas_ead        += $placu_ead;
                  $quantidade_turmas_remoto     += $placu_remoto;
						      $cargahoraria_turmas_tipoacao += $carga_horaria_planilha * $quantidade_turmas;
				          $matriculas_turmas_tipoacao   += $matriculas_total_turma;
				          $receita_turmas_tipoacao      += $receita_prevista_total_aluno;
				          $despesa_turmas_tipoacao      += $custo_total_planilha;
						  
						  //RESUMO DAS UNIDADES...
						  if($codigo_eixo != 8) //EDUCACAO PROFISSIONAL...
						  {
						    $quantidade_turmas_educacao_profissional     += $quantidade_turmas;
								$quantidade_matriculas_educacao_profissional += $matriculas_total_turma;
								$carga_horaria_educacao_profissional         += $carga_horaria_planilha * $quantidade_turmas;
								$receita_prevista_educacao_profissional      += $receita_prevista_total_aluno;
								$despesa_prevista_educacao_profissional      += $custo_planilha * $quantidade_turmas;
								
								//TOTAIS GERAIS.......
								$quantidade_turmas_educacao_profissional_geral     += $quantidade_turmas;
								$quantidade_matriculas_educacao_profissional_geral += $matriculas_total_turma;
								$carga_horaria_educacao_profissional_geral         += $carga_horaria_planilha * $quantidade_turmas;
								$receita_prevista_educacao_profissional_geral      += $receita_prevista_total_aluno;
								$despesa_prevista_educacao_profissional_geral      += $custo_total_planilha;
						  	 
								$hora_aluno_unidade 	        += $calculo1;
								$hora_aluno_total_unidade     += $calculo1;
			          $valor_hora_aluno_total_geral += $calculo1;
						         
						  
						  }
						  else   //AÇÕES EXTENSIVAS...
						  {
						    $quantidade_turmas_acao_extensivas     += $quantidade_turmas;
								$quantidade_matriculas_acao_extensivas += $matriculas_total_turma;
								$carga_horaria_acao_extensivas         += $carga_horaria_planilha * $quantidade_turmas;
								$receita_prevista_acao_extensivas      += $receita_prevista_total_aluno;
								$despesa_prevista_acao_extensivas      += $custo_total_planilha;
								
								//TOTAIS GERAIS.....
								$quantidade_turmas_acao_extensivas_geral     += $quantidade_turmas;
								$quantidade_matriculas_acao_extensivas_geral += $matriculas_total_turma;
								$carga_horaria_acao_extensivas_geral         += $carga_horaria_planilha * $quantidade_turmas;
								$receita_prevista_acao_extensivas_geral      += $receita_prevista_total_aluno;
								$despesa_prevista_acao_extensivas_geral      += $custo_total_planilha;
								 
						  }
						  
						  
				 }// FIM DAS PLANILHAS
			?>
  <tr valign="middle"> 
    <td colspan="4"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><em><strong>TOTAL</strong></em></font></div></td>
    <td><div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_turmas_tipoacao; ?></font></font></div></td>
    <td><div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_turmas_ead; ?></font></font></div></td>
    <td><div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_turmas_remoto; ?></font></font></div></td>
    <td bgcolor="#E0E0E0"> <div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif">-</font></font></div></td>
    <td><div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($cargahoraria_turmas_tipoacao, 0, ',', '.'); ?></font></font></div></td>
    <td><div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($hora_aluno_unidade, 0, ',', '.'); ?></font></font></div></td>
    <td colspan="3" bgcolor="#E0E0E0"> <div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif">-</font></font></div>
      <div align="center"><font size="2"></font></div></td>
    <td><div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo $matriculas_turmas_tipoacao; ?></font></font></div></td>
    <td bgcolor="#E0E0E0"> <div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif">-</font></font></div></td>
    <td><div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($receita_turmas_tipoacao, 2, ',', '.'); ?></font></font></div></td>
    <td bgcolor="#E0E0E0"> <div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif">-</font></font></div></td>
    <td><div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($despesa_turmas_tipoacao, 2, ',', '.'); ?></font></font></div></td>
    <td bgcolor="#E0E0E0"> <div align="center"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif">-</font></font></div></td>
  </tr>
</table>
											 										 
<?php
		} //FIM DOS TIPOS DE AÇÃO...
		   
	} // FIM DOS SEGMENTOS...							
		  
} //FIM DOS EIXOS...
          
?>
			 <table width="100%" border="0">
             <tr> 
             <td width="37%"><table width="100%" border="1" cellspacing="0" bordercolor="#000000">
             <tr valign="middle"> 
             <td colspan="2"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">TOTAIS 
              [ <strong>Educação Profissional </strong>]</font></div></td>
             </tr>
             <tr> 
             <td width="49%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Turmas</font></td>
             <td width="51%" valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_turmas_educacao_profissional; ?></font></div></td>
             </tr>
             <tr> 
             <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Matrículas</font></td>
             <td valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_matriculas_educacao_profissional; ?></font></div></td>
             </tr>
             <tr> 
             <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Carga 
             Horária</font></td>
             <td valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($carga_horaria_educacao_profissional, 0, ',', '.'); ?></font></div></td>
             </tr>
             <tr>
               <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Carga 
             Horária</font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> Aluno</font></td>
               <td valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($hora_aluno_total_unidade, 0, ',', '.'); ?></font></div></td>
             </tr>
             <tr> 
             <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Receita 
             Prevista</font></td>
             <td valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($receita_prevista_educacao_profissional, 2, ',', '.');?></font></div></td>
             </tr>
             <tr> 
             <td height="23" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Despesa</font></td>
             <td valign="middle"><div align="right"><font size="2" face="Verdana, Arial, HelvAetica, sans-serif"><?php echo number_format($despesa_prevista_educacao_profissional, 2, ',', '.');?></font></div></td>
             </tr>
             </table></td>
             <td width="1%">&nbsp;</td>
             <td width="62%"><table width="60%" border="1" cellspacing="0" bordercolor="#000000">
             <tr valign="middle"> 
       		 <td colspan="2"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">TOTAIS 
              [ <strong>A&ccedil;&otilde;es Extensivas </strong>]</font></div></td>
              </tr>
             <tr> 
             <td width="49%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Turmas</font></td>
             <td width="51%"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_turmas_acao_extensivas; ?></font></div></td>
             </tr>
             <tr> 
             <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Matrículas</font></td>
             <td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_matriculas_acao_extensivas; ?></font></div></td>
             </tr>
             <tr> 
    		 <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Carga 
              Horária</font></td>
             <td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $carga_horaria_acao_extensivas; ?></font></div></td>
             </tr>
             <tr> 
             <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Receita 
             Prevista</font></td>
             <td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($receita_prevista_acao_extensivas, 2, ',', '.');?></font></div></td>
             </tr>
             <tr> 
             <td height="23" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Despesa</font></td>
             <td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-seriAf"><?php echo number_format($despesa_prevista_acao_extensivas, 2, ',', '.');?></font></div></td>
             </tr>
             </table></td>
             </tr>
             </table>
             <br>
			
		<?php		 
					 
				
		   }// FIM DAS UNIDADES...
            
		   
		   
		?> 
		  
		
<table width="100%" border="0">
  <tr>
    <td><hr align="left" width="70%"></td>
  </tr>
</table>
<br>
<table width="100%" border="0">
  <tr> 
    <td width="37%"><table width="100%" border="1" cellspacing="0" bordercolor="#000000">
        <tr valign="middle"> 
          <td colspan="2"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">TOTAL 
              GERAL [ <strong>Educação Profissional </strong>]</font></div></td>
        </tr>
        <tr> 
          <td width="49%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Turmas</font></td>
          <td width="51%" valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_turmas_educacao_profissional_geral; ?></font></div></td>
        </tr>
        <tr> 
          <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Matrículas</font></td>
          <td valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($quantidade_matriculas_educacao_profissional_geral, 0, ',', '.'); ?></font></div></td>
        </tr>
        <tr>
          <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Carga 
          Horária Aluno</font></td>
          <td valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($valor_hora_aluno_total_geral, 0, ',', '.'); ?></font></div></td>
        </tr>
        <tr> 
          <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Carga 
            Horária</font></td>
          <td valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($carga_horaria_educacao_profissional_geral, 0, ',', '.'); ?></font></div></td>
        </tr>
        <tr> 
          <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Receita 
            Prevista</font></td>
          <td valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($receita_prevista_educacao_profissional_geral, 2, ',', '.');?></font></div></td>
        </tr>
        <tr> 
          <td height="23" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Despesa</font></td>
          <td valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($despesa_prevista_educacao_profissional_geral, 2, ',', '.');?></font></div></td>
        </tr>
    </table></td>
    <td width="1%">&nbsp;</td>
    <td width="62%"><table width="60%" border="1" cellspacing="0" bordercolor="#000000">
        <tr valign="middle"> 
          <td colspan="2"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">TOTAL 
              GERAL [ <strong>A&ccedil;&otilde;es Extensivas </strong>]</font></div></td>
        </tr>
        <tr> 
          <td width="49%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Turmas</font></td>
          <td width="51%"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_turmas_acao_extensivas_geral; ?></font></div></td>
        </tr>
        <tr> 
          <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Matrículas</font></td>
          <td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($quantidade_matriculas_acao_extensivas_geral, 0, ',', '.'); ?></font></div></td>
        </tr>
        <tr> 
          <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Carga 
            Horária</font></td>
          <td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($carga_horaria_acao_extensivas_geral, 0, ',', '.'); ?></font></div></td>
        </tr>
        <tr> 
          <td valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Receita 
            Prevista</font></td>
          <td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($receita_prevista_acao_extensivas_geral, 2, ',', '.');?></font></div></td>
        </tr>
        <tr> 
          <td height="23" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Despesa</font></td>
          <td><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($despesa_prevista_acao_extensivas_geral, 2, ',', '.');?></font></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
          <table width="100%" border="0">
          <tr>
          <td><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Gerado 
          em: <?php echo date("d/m/Y"); ?> &agrave;s <?php echo date("H:i:s");?></font></div></td>
          </tr>
          </table>