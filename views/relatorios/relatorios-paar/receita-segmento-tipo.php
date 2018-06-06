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
use app\models\cadastros\Unidades;
use app\models\planilhas\Planilhadecurso;
?>

<h1>Relatório Em Produção</h1>


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
           </strong> Receita x Segmento x Tipo A&ccedil;&atilde;o</font></td>
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
           <tr> 
           <td>&nbsp;</td>
           <td valign="middle"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PROGRAMA&Ccedil;&Atilde;O</font></strong></td>
           <td width="3%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $tipo_programacao['tipro_descricao'];?></font></td>
           </tr>
           </table></td>
           </tr>
           <tr>
           <td colspan="4"><hr align="right" width="70%"></td>
           </tr>
           </table>
           <br>
           
         <?php		 
		   //EXTRAINDO AS UNIDADES DAS PLANILHAS....
		    $query_unidades = "SELECT placu_nomeunidade,placu_codunidade FROM planilhadecurso_placu  WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' GROUP BY placu_codunidade ORDER BY placu_nomeunidade";

		    $unidades = Planilhadecurso::findBySql($query_unidades)->all(); 

            foreach ($unidades as $unidade) {

		        $codigo_unidade  = $unidade['placu_codunidade'];
			    $nome_unidade    = $unidade['placu_nomeunidade'];
				 
				   ?>
				   <table width="100%" border="0">
                   <tr> 
                   <td valign="middle"><font size="3" face="Arial, Helvetica, sans-serif"><em><?php echo $nome_unidade; ?></em></font></td>
                   </tr>
                   </table><br>
				   <?php
				   
				   ?>
				   
				   <table border="1" cellspacing="0" bordercolor="#CCCCCC">
                   <tr> 
                   <td height="24"> <table width="100%" border="0">
                   <tr> 
                   <td width="23%" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">SEGMENTO 
                  /<br>
                   TIPO DE A&Ccedil;&Atilde;O</font></strong></font></div></td>
				   
				<?php
				   

				   //EXTRAINDO OS SEGMENTOS
		   			$query_segmentos = "SELECT placu_codsegmento, seg_descricao FROM planilhadecurso_placu, segmento_seg WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$codigo_unidade."' AND placu_codsegmento = seg_codsegmento GROUP BY placu_codsegmento ORDER BY seg_descricao";

		    		$segmentos = Planilhadecurso::findBySql($query_segmentos)->all(); 

		    		foreach ($segmentos as $segmento) {

		    			$codigo_segmento = $segmento['placu_codsegmento'];
						$nome_segmento   = $segmento['segmento']['seg_descricao'];
				?> 

					<td  bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo $nome_segmento; ?></font></strong></font></div></td><?php 						 
				   } //FIM DOS SEGMENTOS....
				   
				    ?> <td  bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">TOTAL</font></strong></font></div></td>
				<?php 						 
				   
				  //EXTRAINDO OS TIPOS DE AÇÃO...
				  $query_tiposAcao = "SELECT placu_codtipoa, tip_descricao FROM planilhadecurso_placu, tipodeacao_tip WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$codigo_unidade."' AND placu_codtipoa = tip_codtipoa GROUP BY placu_codtipoa ORDER BY tip_descricao";

		    		$tiposAcao = Planilhadecurso::findBySql($query_tiposAcao)->all(); 

		    		foreach ($tiposAcao as $tipoAcao) {

				         $codigo_tipo = $tipoAcao['placu_codtipoa'];
						 $nome_tipo   = $tipoAcao['tipo']['tip_descricao'];

						 $valor_total_por_tipo = 0;
				?>
						   </tr>
                           <tr> 
                           <td bgcolor="#EEEEEE"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $nome_tipo ?></font></td>
						   <?php
						   
						   //SEGMENTOS PARA PEGAR A ORDEM
							  $query_segmentos = "SELECT placu_codsegmento, seg_descricao FROM planilhadecurso_placu, segmento_seg WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$codigo_unidade."' AND placu_codsegmento = seg_codsegmento GROUP BY placu_codsegmento ORDER BY seg_descricao";

					    		$segmentos = Planilhadecurso::findBySql($query_segmentos)->all(); 

					    		foreach ($segmentos as $segmento) {

				        		$codigo_segmento = $segmento['placu_codsegmento'];

								$valor_por_tipo = 0;
								 
							  // DADOS PARA CALCULO...
							  $query_planilhas = "SELECT placu_quantidadealunos, placu_valorparcelas, placu_quantidadeturmas FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$codigo_unidade."' AND placu_codsegmento = '".$codigo_segmento."' AND placu_codtipoa = '".$codigo_tipo."' ";


					    		$planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

					    		foreach ($planilhas as $planilha) {

									    $quantidade_alunos  = $planilha['placu_quantidadealunos'];
										$valor_curso        = $planilha['placu_valorparcelas'];
									    $quantidade_turmas  = $planilha['placu_quantidadeturmas'];
									    
										$valor_curso = $quantidade_alunos * $valor_curso;
										$valor_curso = $valor_curso * $quantidade_turmas;
								        
										$valor_por_tipo = $valor_por_tipo + $valor_curso;
										$valor_total_por_tipo = $valor_total_por_tipo + $valor_curso;
						        
								 } // FIM CALCULO
								 
								 ?>
								 <td bgcolor="#EEEEEE"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($valor_por_tipo,2,".",".");?></font></div></td>
								 <?php
								 
						   } // FIM DOS SEGMENTOS
						   ?>
						    <td bgcolor="#EEEEEE"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($valor_total_por_tipo,2,".",".");?></font></div></td>
						   </tr>
						   <?php
						  
				  }// FIM DOS TIPOS DE AÇÃO
						 
				  	       
				   ?>
				    <tr>
					<td  bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">TOTAL</font></strong></font></div></td>
					<?php
					
					$valor_total_por_segmento = 0;
					//SEGMENTOS PARA PEGAR A ORDEM
					$query_planilhas = "SELECT placu_codsegmento, seg_descricao FROM planilhadecurso_placu, segmento_seg WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$codigo_unidade."' AND placu_codsegmento = seg_codsegmento  GROUP BY placu_codsegmento ORDER BY seg_descricao ";

					    		$planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

					    		foreach ($planilhas as $planilha) {

						         $codigo_segmento    = $planilha['placu_codsegmento'];

								 $valor_por_segmento = 0;
						 
						 // DADOS PARA CALCULO...
						 $query_planilhas = "SELECT placu_quantidadealunos, placu_valorparcelas, placu_quantidadeturmas FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$codigo_unidade."' AND placu_codsegmento = '".$codigo_segmento."' ";

					    		$planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

					    		foreach ($planilhas as $planilha) {

				                 $quantidade_alunos  = $planilha['placu_quantidadealunos'];
							     $valor_curso        = $planilha['placu_valorparcelas'];
								 $quantidade_turmas  = $planilha['placu_quantidadeturmas'];

								 $valor_curso = $quantidade_alunos * $valor_curso;
								 $valor_curso = $valor_curso * $quantidade_turmas;
								        
								 $valor_por_segmento       = $valor_por_segmento + $valor_curso;
								 $valor_total_por_segmento = $valor_total_por_segmento + $valor_curso;


						  } // FIM CALCULO
						  ?>
						  
                          <td  bgcolor="#CACACA"> <div align="right"><strong><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($valor_por_segmento,2,".",".");?></font></font></strong></div></td>					  
						  <?php
						  			
					}
					?>
					<td  bgcolor="#CACACA"> <div align="right"><strong><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($valor_total_por_segmento,2,".",".");?></font></font></strong></div></td>					  
					</tr>
					                  
                   </table></td>
                   </tr>
                   </table><br>
				   
				   <?php
				 
			}// FIM DAS UNIDADES...
            ?>
			<br>
			<table width="100%" border="0">
            <tr>
            <td><hr align="left" width="70%">
            </td>
            </tr>
            </table><br>
			
			<table width="100%" border="0">
            <tr> 
            <td valign="middle"><font size="3" face="Arial, Helvetica, sans-serif"><em>QUADRO GERAL</em></font></td>
            </tr>
            </table><br>			
			
			       <table border="1" cellspacing="0" bordercolor="#CCCCCC">
                   <tr> 
                   <td height="24"> <table width="100%" border="0">
                   <tr> 
                   <td width="23%" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">SEGMENTO 
                  /<br>
                   TIPO DE A&Ccedil;&Atilde;O</font></strong></font></div></td>
				   
				    <?php
				   
				   //EXTRAINDO OS SEGMENTOS
				   $query_planilhas = "SELECT placu_codsegmento, seg_descricao FROM planilhadecurso_placu, segmento_seg WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codsegmento = seg_codsegmento  GROUP BY placu_codsegmento ORDER BY seg_descricao ";

					    		$planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

					    		foreach ($planilhas as $planilha) {

							         $codigo_segmento  = $planilha['placu_codsegmento'];
									 $nome_segmento    = $planilha['segmento']['seg_descricao'];
					?> 

					<td  bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo $nome_segmento; ?></font></strong></font></div></td>

				<?php 						 
				   
				   } //FIM DOS SEGMENTOS....
				   
				?> 

				<td  bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">TOTAL</font></strong></font></div></td>

				<?php 						 
				   
				  //EXTRAINDO OS TIPOS DE AÇÃO...
				  $query_tiposAcao = "SELECT placu_codtipoa, tip_descricao FROM planilhadecurso_placu, tipodeacao_tip WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codtipoa = tip_codtipoa GROUP BY placu_codtipoa ORDER BY tip_descricao";

		    		$tiposAcao = Planilhadecurso::findBySql($query_tiposAcao)->all(); 

		    		foreach ($tiposAcao as $tipoAcao) {

				         $codigo_tipo = $tipoAcao['placu_codtipoa'];
						 $nome_tipo   = $tipoAcao['tipo']['tip_descricao'];

						 $valor_total_por_tipo = 0;

			    ?>
						   </tr>
                           <tr> 
                           <td bgcolor="#EEEEEE"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $nome_tipo ?></font></td>
						   <?php
						   
						   //SEGMENTOS PARA PEGAR A ORDEM
						   $query_segmentos = "SELECT placu_codsegmento, seg_descricao FROM planilhadecurso_placu, segmento_seg WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codsegmento = seg_codsegmento GROUP BY placu_codsegmento ORDER BY seg_descricao";

					    		$segmentos = Planilhadecurso::findBySql($query_segmentos)->all(); 

					    		foreach ($segmentos as $segmento) {

				                 $codigo_segmento  = $segmento['placu_codsegmento'];

								 $valor_por_tipo = 0;
								 
								 // DADOS PARA CALCULO...
								 $query_planilhas = "SELECT placu_quantidadealunos, placu_valorparcelas, placu_quantidadeturmas FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' and placu_codsegmento = '".$codigo_segmento."' and placu_codtipoa = '".$codigo_tipo."' ";

					    		$planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

					    		foreach ($planilhas as $planilha) {

									    $quantidade_alunos  = $planilha['placu_quantidadealunos'];
										$valor_curso        = $planilha['placu_valorparcelas'];
									    $quantidade_turmas  = $planilha['placu_quantidadeturmas'];
									    
										$valor_curso = $quantidade_alunos * $valor_curso;
										$valor_curso = $valor_curso * $quantidade_turmas;
								        
										$valor_por_tipo       = $valor_por_tipo + $valor_curso;
										$valor_total_por_tipo = $valor_total_por_tipo + $valor_curso;
						        
								 } // FIM CALCULO
								 
								 ?>
								 <td bgcolor="#EEEEEE" style="padding: 10px;"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($valor_por_tipo,2,".",".");?></font></div></td>
								 <?php
								 
						   } // FIM DOS SEGMENTOS
						   ?>
						    <td bgcolor="#EEEEEE" style="padding: 10px;"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($valor_total_por_tipo,2,".",".");?></font></div></td>
						   </tr>
						   <?php
						  
				  }// FIM DOS TIPOS DE AÇÃO
						 
				   ?>
				    <tr>
					<td  bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">TOTAL</font></strong></font></div></td>
				<?php
					
					$valor_total_por_segmento = 0;

					//SEGMENTOS PARA PEGAR A ORDEM
					$query_segmentos = "SELECT placu_codsegmento, seg_descricao FROM planilhadecurso_placu, segmento_seg WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codsegmento = seg_codsegmento GROUP BY placu_codsegmento ORDER BY seg_descricao";

					    		$segmentos = Planilhadecurso::findBySql($query_segmentos)->all(); 

					    		foreach ($segmentos as $segmento) {

							         $codigo_segmento  = $segmento['placu_codsegmento'];
									 $valor_por_segmento = 0;

						 // DADOS PARA CALCULO...
						 $query_planilhas = "SELECT placu_quantidadealunos, placu_valorparcelas, placu_quantidadeturmas FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codsegmento = '".$codigo_segmento."'";

					    		$planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

					    		foreach ($planilhas as $planilha) {

				                 $quantidade_alunos  = $planilha['placu_quantidadealunos'];
							     $valor_curso        = $planilha['placu_valorparcelas'];
								 $quantidade_turmas  = $planilha['placu_quantidadeturmas'];
									    
								 $valor_curso = $quantidade_alunos * $valor_curso;
								 $valor_curso = $valor_curso * $quantidade_turmas;
								        
								 $valor_por_segmento = $valor_por_segmento + $valor_curso;
								 $valor_total_por_segmento = $valor_total_por_segmento + $valor_curso;
						        
						  } // FIM CALCULO
				?>
						  
                          <td  bgcolor="#CACACA" style="padding: 10px;"> <div align="right"><strong><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($valor_por_segmento,2,".",".");?></font></font></strong></div></td>					  
					<?php
						  			
						}
					?>
					<td  bgcolor="#CACACA" style="padding: 10px;"> <div align="right"><strong><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"><?php echo number_format($valor_total_por_segmento,2,".",".");?></font></font></strong></div></td>					  
					</tr>
					                  
                   </table></td>
                   </tr>
                   </table><br>

          <br>
          <table width="100%" border="0">
          <tr>
          <td><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Gerado 
          em: <?php echo date("d/m/Y"); ?> &agrave;s <?php echo date("H:i:s");?></font></div></td>
          </tr>
          </table>