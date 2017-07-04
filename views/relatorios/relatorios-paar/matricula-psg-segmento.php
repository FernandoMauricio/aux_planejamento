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
use app\models\cadastros\Segmento;
use app\models\planilhas\Planilhadecurso;
?>

<h1>Relatorio em Desenvolvimento</h1>



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
          </strong>Matr&iacute;culas PSG por Segmento</font></td>
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
           <td colspan="3" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Todas</font></td>
           </tr>
           <tr> 
           <td>&nbsp;</td>
           <td valign="middle"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ANO</font></strong></td>
           <td width="12%" valign="middle"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $ano_planilha['an_ano'];?></font></td>
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
		   <BR>
           
           
		   <table width="150%"  border="1" cellspacing="0" bordercolor="#000000">
           <tr>
           <td>
		   
		   
		   <table  border="0">
           <tr> 
           <td  width="30%" valign="middle" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">UNIDADES</font></strong></font></div></td>
		   <?php
				$soma_total_geral = 0;
				$codigo_segmento = 0;
				$conta_segmento[$codigo_segmento] = 0;
				//EXTRAINDO OS SEGMENTOS CADASTRADOS....
				$query_segmentos = "SELECT seg_codsegmento, seg_descricao FROM segmento_seg ORDER BY seg_descricao";

						$segmentos = Segmento::findBySql($query_segmentos)->all(); 

		            	  foreach ($segmentos as $segmento) {

				            $codigo_segmento = $segmento['seg_codsegmento'];
					        $nome_segmento   = $segmento['seg_descricao'];
					 
					 $conta_segmento[$codigo_segmento] = 0;
			?>
			<td width="8%" valign="middle" bgcolor="#CACACA"><div align="center"><strong><font size="1" face="Arial"><?php echo $nome_segmento; ?></font></strong></div></td>
					 
			<?php
			    }
			?>
		   
           <td width="12%" valign="middle" bgcolor="#CACACA">
		   <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">TOTAL</font></strong></font></div>
		   </td>
           </tr>
		    <?php
				//EXTRAINDO AS UNIDADES....
				$query_unidades = "SELECT placu_nomeunidade,placu_codunidade FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' GROUP BY placu_codunidade ORDER BY placu_nomeunidade";
			    $unidades = Planilhadecurso::findBySql($query_unidades)->all(); 

	            foreach ($unidades as $unidade) {

		             $codigo_unidade = $unidade['placu_codunidade'];
			         $nome_unidade   = $unidade['placu_nomeunidade'];
					 
					 $subtotal_unidade = 0;
			?>
					  <tr> 
                      <td valign="middle" bgcolor="#EEEEEE"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $nome_unidade; ?></font></td>
                     
                    <?php
					  //RESGATANDO OS EIXOS CONFORME ORDEM DO CABEÇALHO...
					  $query_segmentos = "SELECT seg_codsegmento, seg_descricao FROM segmento_seg ORDER BY seg_descricao";

						$segmentos = Segmento::findBySql($query_segmentos)->all(); 

		            	  foreach ($segmentos as $segmento) {

		                     $codigo_segmento  = $segmento['seg_codsegmento'];
					         
							 $quantidade_matriculas_por_segmento = 0;
							 //EXTRAINDO AS QUANTIDADES CONFORME O SEGMENTO E UNIDADE....
							 $query_planilhas = "SELECT placu_quantidadeturmas, placu_quantidadealunos,placu_quantidadealunospsg, placu_quantidadealunosisentos FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$codigo_unidade."' AND placu_codsegmento = '".$codigo_segmento."'";

				            $planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

	            	 		foreach ($planilhas as $planilha) {
							 
					               $quantidade_turmas      = $planilha['placu_quantidadeturmas'];
					               $quantidade_alunos      = 0; //$planilha['placu_quantidadealunos'];
								   $quantidade_alunos_psg  = $planilha['placu_quantidadealunospsg'];
					               
								   $somar_matriculas = $quantidade_alunos + $quantidade_alunos_psg;
								   
								   $quantidade_matriculas_por_segmento = $quantidade_matriculas_por_segmento + ($quantidade_turmas * $somar_matriculas);
								   $soma_total_geral                   = $soma_total_geral + ($quantidade_turmas * $somar_matriculas);
					        }// FIM DAS QUANTIDADES..
					        
							$conta_segmento[$codigo_segmento] = $conta_segmento[$codigo_segmento] + $quantidade_matriculas_por_segmento;
							$subtotal_unidade                 = $subtotal_unidade + $quantidade_matriculas_por_segmento;
					?>
							 <td bgcolor="#EEEEEE"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_matriculas_por_segmento; ?></font></div></td>
					<?php
					  }// FIM DOS EIXOS...
					?>
					  <td bgcolor="#EEEEEE"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $subtotal_unidade; ?></font></div></td>
                      </tr>     
			<?php
		        } // FIM DAS UNIDADES...
		    ?>
           <tr> 
           <td valign="middle" bgcolor="#CACACA"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>TOTAL 
           GERAL </strong></font></div></td>
           
            <?php
			        $query_segmentos = "SELECT seg_codsegmento, seg_descricao FROM segmento_seg ORDER BY seg_descricao";

				  				$segmentos = Segmento::findBySql($query_segmentos)->all(); 

				              	  foreach ($segmentos as $segmento) {

				               $codigo_segmento  = $segmento['seg_codsegmento'];
		    ?>
					  <td bgcolor="#CACACA"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $conta_segmento[$codigo_segmento] ;?> </strong></font></div></td>
					  
		<?php
			}
		?>
		  
          <td bgcolor="#CACACA"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $soma_total_geral; ?></strong></font></div></td>
           </tr>
           </table>
		   
		   </td>
           </tr>
           </table>
		   
		   <br>
           <table width="100%" border="0">
           <tr>
           <td><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Gerado 
           em: <?php echo date("d/m/Y"); ?> &agrave;s <?php echo date("H:i:s");?></font></div></td>
           </tr>
           </table>

