<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\cadastros\Ano;
use app\models\cadastros\Tipoplanilha;
use app\models\cadastros\Situacaoplanilha;
use app\models\cadastros\Eixo;
use app\models\cadastros\Segmento;
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
    <td align="left" valign="middle"><font size="3" face="Verdana, Arial, Helvetica, sans-serif">Aux&iacute;lio 
      ao Planejamento<strong><br>
      </strong>Matr&iacute;culas por Segmento e Tipo de Ação</font><em></em></td>
  </tr>
  <tr> 
    <td colspan="3"><hr align="left" width="70%"></td>
  </tr>
  <tr> 
    <td colspan="3"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">CRIT&Eacute;RIOS 
      DO RELAT&Oacute;RIO</font></td>
  </tr>
  <tr> 
    <td colspan="3"><table width="100%" border="0">
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
    <td colspan="3"><hr align="right" width="70%"></td>
  </tr>
</table>
		   <BR>
           
        <?php
		  //EXTRAINDO AS UNIDADES....
		  $query_unidades = "SELECT placu_nomeunidade,placu_codunidade FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."'  group by placu_codunidade ORDER BY placu_nomeunidade";
			    $unidades = Planilhadecurso::findBySql($query_unidades)->all(); 

	            foreach ($unidades as $unidade) {

			        $codigo_unidade  = $unidade['placu_codunidade'];
				    $nome_unidade    = $unidade['placu_nomeunidade'];

		?>
				  <table width="100%" border="0">
                  <tr> 
                  <td valign="middle"><font size="3" face="Arial, Helvetica, sans-serif"><em><?php echo $nome_unidade; ?></em></font></td>
                  </tr>
                  </table>
				  
				  <table width="100%" border="1" cellspacing="0" bordercolor="#000000">
                  <tr> 
                  <td> <table width="100%" border="0">
                  <tr> 
                  <td width="22%" valign="middle" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">SEGMENTO / TIPO AÇÃO 
                  </font></strong></font></div></td>
				  
				<?php
				  
				  $query_tiposAcao = "SELECT tip_codtipoa, tip_descricao FROM tipodeacao_tip ,planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codtipoa = tip_codtipoa GROUP BY placu_codtipoa ORDER BY tip_descricao";

		    		$tiposAcao = Tipo::findBySql($query_tiposAcao)->all(); 

		    		foreach ($tiposAcao as $tipoAcao) {

		            $codigo_tipoacao  = $tipoAcao['tip_codtipoa'];
			        $nome_tipoacao    = $tipoAcao['tip_descricao'];
				     
				?>
					 <td width="66%" bgcolor="#CACACA" align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $nome_tipoacao; ?></font></td>
				<?php
					  } 
                ?>
				  <td width="12%" valign="middle" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">TOTAL</font></strong></font></div></td>
                  </tr>
				  
				<?php
					  $query_segmentos = "SELECT seg_codsegmento, seg_descricao FROM segmento_seg, planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codsegmento = seg_codsegmento GROUP BY placu_codsegmento ORDER BY seg_descricao";

						$segmentos = Segmento::findBySql($query_segmentos)->all(); 

		            	  foreach ($segmentos as $segmento) {

				            $codigo_segmento = $segmento['seg_codsegmento'];
					        $nome_segmento   = $segmento['seg_descricao'];
							
							$soma_segmento = 0;
				?>
					 <tr> 
                     <td valign="middle" bgcolor="#EEEEEE"> <div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $nome_segmento; ?></strong></font></div></td>
				<?php
					 
					$query_tiposAcao = "SELECT tip_codtipoa, tip_descricao FROM tipodeacao_tip ,planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codtipoa = tip_codtipoa GROUP BY placu_codtipoa ORDER BY tip_descricao";

		    		$tiposAcao = Tipo::findBySql($query_tiposAcao)->all(); 

		    		foreach ($tiposAcao as $tipoAcao) {

		                  $codigo_tipoacao = $tipoAcao['tip_codtipoa'];
			              $nome_tipoacao   = $tipoAcao['tip_descricao'];
					      
						  $soma_segmento_tipoacao = 0;

					$query_planilhas = "SELECT placu_quantidadeturmas, placu_quantidadealunos, placu_quantidadealunospsg, placu_quantidadealunosisentos FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$codigo_unidade."' AND placu_codsegmento = '".$codigo_segmento."' AND placu_codtipoa = '".$codigo_tipoacao."'";

				            $planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

	            	 		foreach ($planilhas as $planilha) {

		                      $quantidade_turmas      = $planilha['placu_quantidadeturmas'];
			                  $quantidade_pagantes    = $planilha['placu_quantidadealunos'];
							  $quantidade_psg         = $planilha['placu_quantidadealunospsg'];
							  $quantidade_isentos     = $planilha['placu_quantidadealunosisentos'];
							  
							  $quantidade_alunos      = $quantidade_pagantes + $quantidade_psg + $quantidade_isentos;
							  $calculo                = $quantidade_alunos  * $quantidade_turmas;
							  $soma_segmento_tipoacao = $soma_segmento_tipoacao + $calculo;
							  $soma_segmento          = $soma_segmento + ($quantidade_alunos  * $quantidade_turmas);
					}
						 					  
						  ?>
						  <td  bgcolor="#CACACA" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $soma_segmento_tipoacao; ?></font></td>
				<?php
						  
					 }
				?>
					 <td bgcolor="#EEEEEE" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $soma_segmento; ?></font></td>
                     </tr>
			    <?php
				  
				  }
				?>
                  			  
				  <tr> 
                  <td valign="middle" bgcolor="#CACACA"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>TOTAL 
                  GERAL </strong></font></div></td>
				  
				  <?php
					  $conta_total_unidade = 0;

					  $query_tiposAcao = "SELECT tip_codtipoa, tip_descricao FROM tipodeacao_tip ,planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codtipoa = tip_codtipoa GROUP BY placu_codtipoa ORDER BY tip_descricao";

			    		$tiposAcao = Tipo::findBySql($query_tiposAcao)->all(); 

			    		foreach ($tiposAcao as $tipoAcao) {

			            $codigo_tipoacao  = $tipoAcao['tip_codtipoa'];
				        $nome_tipoacao    = $tipoAcao['tip_descricao'];
							  
						$soma_tipoacao = 0;

							$query_planilhas = "SELECT placu_quantidadeturmas, placu_quantidadealunos, placu_quantidadealunospsg, placu_quantidadealunosisentos FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codtipoa = '".$codigo_tipoacao."' AND placu_codunidade = '".$codigo_unidade."'";

					            $planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

		            	 		foreach ($planilhas as $planilha) {

			                      $quantidade_turmas   = $planilha['placu_quantidadeturmas'];
				                  $quantidade_pagantes = $planilha['placu_quantidadealunos'];
								  $quantidade_psg      = $planilha['placu_quantidadealunospsg'];
								  $quantidade_isentos  = $planilha['placu_quantidadealunosisentos'];
								  
								  $quantidade_alunos   = $quantidade_pagantes + $quantidade_psg + $quantidade_isentos;
								  $calculo             = $quantidade_alunos  * $quantidade_turmas;
								  $soma_tipoacao       = $soma_tipoacao + ($quantidade_alunos  * $quantidade_turmas);
								  $conta_total_unidade = $conta_total_unidade + ($quantidade_alunos  * $quantidade_turmas);
							  }
				?>
						  
						  <td bgcolor="#CACACA" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $soma_tipoacao; ?></font></td>
						  
				<?php
				 	 }
				?>
				  			  
                  <td bgcolor="#CACACA" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $conta_total_unidade; ?></font></td>
                  </tr>
                  </table></td>
                  </tr>
                  </table><br>
		  <?php	  
		  }// FIM DAS UNIDADES
		 		  
		  
		  // TOTAL GERAL..............
		  ?> 
		 
		  <table width="100%" border="0">
          <tr> 
          
          
    <td valign="middle"> <div align="left"><font size="3" face="Arial, Helvetica, sans-serif"><em>QUADRO 
        GERAL</em></font></div></td>
          </tr>
          </table>
				  
		  <table width="100%" border="1" cellspacing="0" bordercolor="#000000">
          <tr> 
          <td> <table width="100%" border="0">
          <tr> 
          <td width="22%" valign="middle" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">SEGMENTO / TIPO AÇÃO 
          </font></strong></font></div></td>
		  
		    <?php
			  $query_tiposAcao = "SELECT tip_codtipoa, tip_descricao FROM tipodeacao_tip ,planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codtipoa = tip_codtipoa GROUP BY placu_codtipoa ORDER BY tip_descricao";

				    		$tiposAcao = Tipo::findBySql($query_tiposAcao)->all(); 

				    		foreach ($tiposAcao as $tipoAcao) {

				            $codigo_tipoacao  = $tipoAcao['tip_codtipoa'];
					        $nome_tipoacao    = $tipoAcao['tip_descricao'];

		    ?>
				 <td width="66%" bgcolor="#CACACA" align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $nome_tipoacao; ?></font></td>
			<?php
		  		} 
            ?>
		  <td width="12%" valign="middle" bgcolor="#CACACA"> <div align="center"><font size="1"><strong><font face="Verdana, Arial, Helvetica, sans-serif">TOTAL</font></strong></font></div></td>
          </tr>
				  
		    <?php
				  $query_segmentos = "SELECT seg_codsegmento, seg_descricao FROM segmento_seg ,planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codsegmento = seg_codsegmento GROUP BY placu_codsegmento ORDER BY seg_descricao";

					    		$segmentos = Segmento::findBySql($query_segmentos)->all(); 

					    		foreach ($segmentos as $segmento) {

							        $codigo_segmento  = $segmento['seg_codsegmento'];
							        $nome_segmento    = $segmento['seg_descricao'];
										 
							        $soma_segmento = 0;
			?>
				<tr> 
                <td valign="middle" bgcolor="#EEEEEE"> <div align="left"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><?php echo $nome_segmento; ?></strong></font></div></td>
				<?php
						$query_tiposAcao = "SELECT tip_codtipoa, tip_descricao FROM tipodeacao_tip ,planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codtipoa = tip_codtipoa GROUP BY placu_codtipoa ORDER BY tip_descricao";

						    		$tiposAcao = Tipo::findBySql($query_tiposAcao)->all(); 

						    		foreach ($tiposAcao as $tipoAcao) {

						                $codigo_tipoacao  = $tipoAcao['tip_codtipoa'];
							            $nome_tipoacao    = $tipoAcao['tip_descricao'];
							      
								 		$soma_segmento_tipoacao = 0;

								 	$query_planilhas = "SELECT placu_quantidadeturmas, placu_quantidadealunos,placu_quantidadealunospsg, placu_quantidadealunosisentos FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$codigo_unidade."' AND placu_codtipoa = '".$codigo_tipoacao."' AND placu_codsegmento = '".$codigo_segmento."'";

						            $planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

			            	 		foreach ($planilhas as $planilha) {
			            	 		
				                      $quantidade_turmas   = $planilha['placu_quantidadeturmas'];
					                  $quantidade_pagantes = $planilha['placu_quantidadealunos'];
									  $quantidade_psg      = $planilha['placu_quantidadealunospsg'];
									  $quantidade_isentos  = $planilha['placu_quantidadealunosisentos'];
									  
									  $quantidade_alunos      = $quantidade_pagantes + $quantidade_psg + $quantidade_isentos;
									  $calculo                = $quantidade_alunos  * $quantidade_turmas;
									  $soma_segmento_tipoacao = $soma_segmento_tipoacao + $calculo;
									  $soma_segmento          = $soma_segmento + ($quantidade_alunos  * $quantidade_turmas);
						  }
				?>
						  <td  bgcolor="#CACACA" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $soma_segmento_tipoacao; ?></font></td>
					<?php
					 	}
					?>
					 <td bgcolor="#EEEEEE" algn="center"><div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $soma_segmento; ?></font></div></td>
                     </tr>
					<?php
					 	}
		            ?>
				  <tr> 
                  <td valign="middle" bgcolor="#CACACA"><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>TOTAL 
                  GERAL </strong></font></div></td>
				  
				  
				<?php

				  $conta_total_geral = 0;
				  $query_tiposAcao = "SELECT tip_codtipoa, tip_descricao FROM tipodeacao_tip ,planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codtipoa = tip_codtipoa GROUP BY placu_codtipoa ORDER BY tip_descricao";

						    		$tiposAcao = Tipo::findBySql($query_tiposAcao)->all(); 

						    		foreach ($tiposAcao as $tipoAcao) {

		                                $codigo_tipoacao  = $tipoAcao['tip_codtipoa'];
							            $nome_tipoacao    = $tipoAcao['tip_descricao'];
						  
						  $soma_tipoacao = 0;

						  $query_planilhas = "SELECT placu_quantidadeturmas, placu_quantidadealunos,placu_quantidadealunospsg, placu_quantidadealunosisentos FROM planilhadecurso_placu WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano ='".$ano_planilha['an_codano']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' AND placu_codunidade = '".$codigo_unidade."' AND placu_codtipoa = '".$codigo_tipoacao."' AND placu_codsegmento = '".$codigo_segmento."' ";

						            $planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

			            	 		foreach ($planilhas as $planilha) {

		                      $quantidade_turmas   = $planilha['placu_quantidadeturmas'];
			                  $quantidade_pagantes = $planilha['placu_quantidadealunos'];
							  $quantidade_psg      = $planilha['placu_quantidadealunospsg'];
							  $quantidade_isentos  = $planilha['placu_quantidadealunosisentos'];
							  
							  $quantidade_alunos   = $quantidade_pagantes + $quantidade_psg + $quantidade_isentos;
							  $calculo             = $quantidade_alunos  * $quantidade_turmas;
							  $soma_tipoacao       = $soma_tipoacao + ($quantidade_alunos  * $quantidade_turmas);
							  $conta_total_geral   = $conta_total_geral + ($quantidade_alunos  * $quantidade_turmas);
						  }
				?>
						  
						  <td bgcolor="#CACACA" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $soma_tipoacao; ?></font></td>
						  
				<?php
					  }
     			?>
				  			  
                  <td bgcolor="#CACACA" align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><?php echo $conta_total_geral; ?></font></td>
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
