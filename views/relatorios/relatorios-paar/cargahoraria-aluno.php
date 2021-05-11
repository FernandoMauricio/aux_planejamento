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
           </strong>Carga Horária Aluno</font></td>
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

          <div class="container">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>UNIDADES</th>
                  <th>EDUCAÇÃO <br> PROFISSIONAL</th>
                  <th>AÇÕES  <br>  EXTENSIVAS </th>
                  <th>TOTAL</th>
                </tr>
              </thead>
              <tbody>
        <?php
		   
		   $total_geral = 0;
		   $quantidade_educacao_profissional_geral = 0;
       $quantidade_acao_extensiva_geral = 0;
		   $quantidade_acao_extensiva = 0;
		   
		   //EXTRAINDO AS UNIDADES DAS PLANILHAS....

		    $query_unidades = "SELECT placu_nomeunidade,placu_codunidade FROM planilhadecurso_placu  WHERE placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."' group by placu_codunidade order by placu_nomeunidade";

		    $unidades = Planilhadecurso::findBySql($query_unidades)->all(); 

           foreach ($unidades as $unidade) {

		      $codigo_unidade  = $unidade['placu_codunidade'];
			    $nome_unidade    = $unidade['placu_nomeunidade'];
				  
				  $quantidade_educacao_profissional = 0;
				  $quantidade_acao_extensiva = 0;
				  $subtotal_unidade = 0;
				  
				  //EXRAINDO AS INFORMAÇÕES DAS PLANILHAS...
				$query_planilhas = "SELECT placu_codeixo,placu_quantidadeturmas,placu_quantidadealunos,placu_quantidadealunosisentos,placu_quantidadealunospsg, placu_cargahorariaarealizar FROM planilhadecurso_placu WHERE placu_codunidade = '".$codigo_unidade."' AND placu_codsituacao = '".$situacao_planilha['sipla_codsituacao']."' AND placu_codano = '".$ano_orcamento['an_codano']."' AND placu_codprogramacao = '".$tipo_programacao['tipro_codprogramacao']."' AND placu_codtipla = '".$tipo_planilha['tipla_codtipla']."'";
        $planilhas = Planilhadecurso::findBySql($query_planilhas)->all(); 

           foreach ($planilhas as $planilha) {

					   $codigo_eixo               = $planilha['placu_codeixo'];
					   $quantidade_turmas         = $planilha['placu_quantidadeturmas'];
						 $quantidade_alunos         = $planilha['placu_quantidadealunos'];
						 $quantidade_alunos_psg     = $planilha['placu_quantidadealunospsg'];
						 $quantidade_alunos_isentos = $planilha['placu_quantidadealunosisentos'];
             $carga_horariaarealizar    = $planilha['placu_cargahorariaarealizar'];
             $carga_horariavivencia     = $planilha['placu_cargahorariavivencia'];
						 
						 
						 $soma_matricula = $quantidade_alunos + $quantidade_alunos_psg + $quantidade_alunos_isentos;
						 
						 if($codigo_eixo != 8)//SEM EIXO
						 {
						      $quantidade_educacao_profissional       += $quantidade_turmas * $soma_matricula * $carga_horariaarealizar;   
							    $quantidade_educacao_profissional_geral += $quantidade_turmas * $soma_matricula * $carga_horariaarealizar;
						 }
						 else
						 {
						      $quantidade_acao_extensiva       += $quantidade_turmas * $soma_matricula * ($carga_horariaarealizar + $carga_horariavivencia);
							    $quantidade_acao_extensiva_geral += $quantidade_turmas * $soma_matricula * ($carga_horariaarealizar + $carga_horariavivencia);
						 }
		          
				  }//FIM DAS PLANILHAS
				  
				  $subtotal_unidade = $quantidade_educacao_profissional + $quantidade_acao_extensiva;
				  $total_geral      = $total_geral + $subtotal_unidade;

				  ?>
                  <tr> 
                  <td><?php echo $nome_unidade; ?></td>
                  <td><?php echo $quantidade_educacao_profissional; ?></td>
                  <td><?php echo $quantidade_acao_extensiva; ?></td>
                  <td><?php echo $subtotal_unidade; ?></td>
                  </tr>
           <?php
		   
		   }// FIM DAS UNIDADES
		   
		   ?>
                 <tr style="background-color: #fcf8e3;">
                 <td><strong>TOTAL GERAL<strong></td>
                 <td><?php echo $quantidade_educacao_profissional_geral; ?></td>
                 <td><?php echo $quantidade_acao_extensiva_geral; ?></td>
                 <td><?php echo $total_geral; ?></td>
                 </tr>

              </tbody>
            </table>
          </div>
				 
				 <br>
                 <table width="100%" border="0">
                 <tr>
                 <td><div align="right"><font size="1" face="Verdana, Arial, Helvetica, sans-serif">Gerado 
                 em: <?php echo date("d/m/Y"); ?> &agrave;s <?php echo date("H:i:s");?></font></div></td>
                 </tr>
                 </table>