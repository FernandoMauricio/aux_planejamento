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
           </strong> Listagem de Cursos Previstos</font></td>
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
           <br>

         <?php		 
			
			$quantidade_turmas_totalgeral = 0;
			$quantidade_alunos_totalgeral = 0;
			
			//EXTRAINDO OS EIXOS

		   //EXTRAINDO AS UNIDADES DAS PLANILHAS....
		    $query_eixos = "SELECT placu_codeixo, eix_descricao FROM planilhadecurso_placu, eixo_eix WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codeixo = eix_codeixo GROUP BY placu_codeixo ORDER BY eix_descricao";

		    $eixos = Planilhadecurso::findBySql($query_eixos)->all(); 

            foreach ($eixos as $eixo) {

			       $codigo_eixo = $eixo['placu_codeixo'];
				   $nome_eixo   = $eixo['eixo']['eix_descricao'];
				 
				   ?>
				   <table width="100%" border="0">
                   <tr> 
                   <td valign="middle" bgcolor="#E0E0E0"><font size="3" face="Arial, Helvetica, sans-serif"><em><?php echo $nome_eixo; ?></em></font></td>
                   </tr>
                   </table>
				   <?php
				   
				   // EXTRAINDO SEGMENTOS
					   $query_segmentos = "SELECT placu_codsegmento, seg_descricao FROM planilhadecurso_placu, segmento_seg WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codeixo = '".$codigo_eixo."' AND placu_codsegmento = seg_codsegmento GROUP BY placu_codsegmento ORDER BY seg_descricao";

						    $segmentos = Planilhadecurso::findBySql($query_segmentos)->all(); 

				            foreach ($segmentos as $segmento) {

				             $codigo_segmento = $segmento['placu_codsegmento'];
					         $nome_segmento   = $segmento['segmento']['seg_descricao'];
							 
							 $total_turmas_geral = 0;
						     $total_alunos_geral = 0;
						 
					?>
						 <table width="100%" border="0">
                         <tr> 
                         <td width="7%" valign="middle">&nbsp;</td>
                         <td width="93%" valign="middle" bgcolor="#E0E0E0"><font size="3" face="Arial, Helvetica, sans-serif"><em><?php echo $nome_segmento; ?></em></font></td>
                         </tr>
                         </table>
						 
						 
<table width="100%" border="0">
  <tr> 
    <td width="7%" valign="middle">&nbsp;</td>
    <td width="7%" valign="middle"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">C&Oacute;D</font></div></td>
    <td valign="middle"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">PLANO 
      DE A&Ccedil;&Atilde;O</font></td>
    <td valign="middle"><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">TURMAS</font></div></td>
    <td valign="middle"><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">ALUNOS</font></div></td>
    <td valign="middle">&nbsp;</td>
  </tr>
 			<?php
						$query_planos = "SELECT placu_codplano, plan_descricao FROM planilhadecurso_placu, planodeacao_plan WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codeixo = '".$codigo_eixo."' AND placu_codsegmento = '".$codigo_segmento."' AND placu_codplano = plan_codplano GROUP BY placu_codplano ORDER BY plan_descricao ";

						    $planos = Planilhadecurso::findBySql($query_planos)->all(); 

				            foreach ($planos as $plano) {

		        	           $codigo_plano = $plano['placu_codplano'];
				                 $nome_plano   = $plano['plano']['plan_descricao'];
						         
        								 $quantidade_turmas_total = 0;
        								 $quantidade_alunos_total = 0;

						$query_planilhas = "SELECT placu_quantidadeturmas, placu_quantidadealunos, placu_quantidadealunospsg, placu_quantidadealunosisentos FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codeixo = '".$codigo_eixo."' AND placu_codsegmento = '".$codigo_segmento."' AND placu_codplano = '".$codigo_plano."'";

						    $planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

				            foreach ($planilhas as $planilha) {

								   $quantidade_turmas         = $planilha["placu_quantidadeturmas"]; 
									 $quantidade_alunos         = $planilha["placu_quantidadealunos"];
									 $quantidade_alunospsg      = $planilha["placu_quantidadealunospsg"];
									 $quantidade_alunos_isentos = $planilha["placu_quantidadealunosisentos"];
									 
									 $quantidade_turmas_total = $quantidade_turmas_total + $quantidade_turmas;
									 
									 $calculo                 = $quantidade_turmas * ($quantidade_alunos + $quantidade_alunospsg + $quantidade_alunos_isentos);
									 $quantidade_alunos_total = $quantidade_alunos_total + $calculo;
									 
									 $total_turmas_geral = $total_turmas_geral + $quantidade_turmas;
									 $total_alunos_geral = $total_alunos_geral + $calculo;
									 
									 $quantidade_turmas_totalgeral = $quantidade_turmas_totalgeral + $quantidade_turmas;
									 $quantidade_alunos_totalgeral = $quantidade_alunos_totalgeral + $calculo;
								 }
			?>
                                 <tr> 
                                 <td valign="middle">&nbsp;</td>
                                 <td valign="middle"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $codigo_plano; ?></font></div></td>
                                 <td width="62%" valign="middle"><font size="3" face="Arial, Helvetica, sans-serif"><em><?php echo $nome_plano; ?></em></font></td>
                                 <td width="8%" valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_turmas_total; ?></font></div></td>
                                 <td width="8%" valign="middle"><div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_alunos_total; ?></font></div></td>
                                 <td width="8%" valign="middle"><div align="center"><a href="index.php?r=relatorios/relatorios-paar/listagem-cursos-previstos-detalhes&ano_planilha=<?php echo $ano_planilha['an_codano']; ?>&tipo_planilha=<?php echo $tipo_planilha['tipla_codtipla']; ?>&situacao_planilha=<?php echo $situacao_planilha['sipla_codsituacao']; ?>&tipo_relatorio=<?php echo $tipo_relatorio['tiprel_id']; ?>&codplano=<?php echo $codigo_plano; ?>" target="_blank"> <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span></a></div></td>
                                 </tr>
              <?php

        						 } // FIM DOS CURSOS
        						 echo "<br>";
						  ?>
  <tr> 
    <td colspan="2" valign="middle">&nbsp;</td>
    <td valign="middle">&nbsp;</td>
    <td valign="middle"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $total_turmas_geral; ?></strong></font></div></td>
    <td valign="middle"> <div align="right"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $total_alunos_geral; ?></strong></font></div></td>
    <td valign="middle">&nbsp;</td>
  </tr>
</table>

<br>
		<?php												 			 
				} // FIM SEGMENTO
				   
			}// FIM DOS EIXOS....	  
			
		?>
          
		  <table width="100%" border="0">
  <tr>
    <td bgcolor="#E0E0E0">
<table width="27%" border="1" align="center" cellspacing="0" bordercolor="#E0E0E0">
        <tr> 
          <td colspan="2" bgcolor="#E0E0E0"> 
            <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>TOTAL 
              GERAL</strong></font></div></td>
        </tr>
        <tr> 
          <td width="50%" bgcolor="#E0E0E0"> 
            <div align="center"><strong><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>TURMAS</strong></font></strong></div></td>
          <td width="50%" bgcolor="#E0E0E0"> 
            <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>ALUNOS</strong></font></div></td>
        </tr>
        <tr> 
          <td bgcolor="#FFFFFF">
<div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_turmas_totalgeral; ?></font></div></td>
          <td bgcolor="#FFFFFF">
<div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_alunos_totalgeral; ?></font></div></td>
        </tr>
      </table>
    </td>
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
