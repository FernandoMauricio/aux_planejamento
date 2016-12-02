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
           <font size="3" face="Verdana, Arial, Helvetica, sans-serif"><strong>M&oacute;dulo: 
           </strong><strong><br>
           Relat&oacute;rio: </strong></font><br>
           <br>
           </p></td>
           <td width="41%" align="left" valign="middle"><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Aux&iacute;lio 
           ao Planejamento<strong><br>
           </strong>Matr&iacute;cula por Unidade</font></td>
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
<table width="100%" border="1" cellspacing="0" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0">
        <tr> 
          <td width="50%" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">UNIDADES</font></strong></font></div></td>
          <td width="19%" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">EDUCA&Ccedil;&Atilde;O 
              <br>
              PROFISSIONAL </font></strong></font></div></td>
          <td width="17%" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">A&Ccedil;&Otilde;ES 
              <br>
              EXTENSIVAS </font></strong></font></div></td>
          <td width="14%" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">TOTAL</font></strong></font></div></td>
        </tr>
        <?php
		   
		   $total_geral = 0;
		   $quantidade_educacao_profissional_geral = 0;
       $quantidade_acao_extensiva_geral = 0;
		   $quantidade_acao_extensiva = 0;
		   
		   //EXTRAINDO AS UNIDADES DAS PLANILHAS....

		    $query_unidades = "SELECT placu_nomeunidade,placu_codunidade FROM planilhadecurso_placu  WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' group by placu_codunidade order by placu_nomeunidade";

		    $unidades = Planilhadecurso::findBySql($query_unidades)->all(); 

           foreach ($unidades as $unidade) {

		      $codigo_unidade  = $unidade['placu_codunidade'];
			    $nome_unidade    = $unidade['placu_nomeunidade'];
				  
				  $quantidade_educacao_profissional = 0;
				  $quantidade_acao_extensiva = 0;
				  $subtotal_unidade = 0;
				  
				  //EXRAINDO AS INFORMAÇÕES DAS PLANILHAS...
				$query_planilhas = "SELECT placu_codeixo,placu_quantidadeturmas,placu_quantidadealunos,placu_quantidadealunosisentos,placu_quantidadealunospsg FROM planilhadecurso_placu WHERE placu_codunidade = '".$codigo_unidade."' AND placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."'";
        $planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

           foreach ($planilhas as $planilha) {

					   $codigo_eixo               = $planilha['placu_codeixo'];
					   $quantidade_turmas         = $planilha['placu_quantidadeturmas'];
						 $quantidade_alunos         = $planilha['placu_quantidadealunos'];
						 $quantidade_alunos_psg     = $planilha['placu_quantidadealunospsg'];
						 $quantidade_alunos_isentos = $planilha['placu_quantidadealunosisentos'];
						 
						 
						 $soma_matricula = $quantidade_alunos + $quantidade_alunos_psg + $quantidade_alunos_isentos;
						 
						 if($codigo_eixo != 8)//SEM EIXO
						 {
						      $quantidade_educacao_profissional       += $quantidade_turmas * $soma_matricula;   
							    $quantidade_educacao_profissional_geral += $quantidade_turmas * $soma_matricula;
						 }
						 else
						 {
						      $quantidade_acao_extensiva       += $quantidade_turmas * $soma_matricula;
							    $quantidade_acao_extensiva_geral += $quantidade_turmas * $soma_matricula;
						 }
		          
				  }//FIM DAS PLANILHAS
				  
				  $subtotal_unidade = $quantidade_educacao_profissional + $quantidade_acao_extensiva;
				  $total_geral      = $total_geral + $subtotal_unidade;

				  ?>
                  <tr> 
                  <td bgcolor="#EEEEEE"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $nome_unidade; ?></font></td>
                  <td bgcolor="#EEEEEE"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_educacao_profissional; ?></font></div></td>
                  <td bgcolor="#EEEEEE"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $quantidade_acao_extensiva; ?></font></div></td>
                  <td bgcolor="#EEEEEE"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $subtotal_unidade; ?></font></div></td>
                  </tr>
           <?php
		   
		   }// FIM DAS UNIDADES
		   
		   ?>
                 <tr> 
                 <td bgcolor="#CACACA"> <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>TOTAL 
                 GERAL </strong></font></div></td>
                 <td bgcolor="#EEEEEE"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $quantidade_educacao_profissional_geral; ?></strong></font></div></td>
                 <td bgcolor="#EEEEEE"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $quantidade_acao_extensiva_geral; ?></strong></font></div></td>
                 <td bgcolor="#EEEEEE"> <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $total_geral; ?></strong></font></div></td>
                 </tr>
                 </table></td>
                 </tr>
                 </table>
                 </td>
                 </tr> </table> 
				 
				 <br>
                 <table width="100%" border="0">
                 <tr>
                 <td><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Gerado 
                 em: <?php echo date("d/m/Y"); ?> &agrave;s <?php echo date("H:i:s");?></font></div></td>
                 </tr>
                 </table>