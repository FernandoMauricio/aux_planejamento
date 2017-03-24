<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\base\Unidade;
use app\models\cadastros\Ano;
use app\models\modeloa\ModeloA;
use app\models\modeloa\DetalhesModeloA;
use app\models\modeloa\OrcamentoPrograma;
?>
	


<title>Relatório por Unidades / Elemento de Despesa- Orçado</title>
					
					 <table width="100%" border="0">
                     <tr> 
                     <td width="19%"><img height="100px" src="<?php echo Url::base().'/uploads/logo.png'?>"></td>
                     <td width="81%">&nbsp;</td>
                     </tr>
                     </table>
		             <br>

<style type="text/css">
       .wrap > .container {padding: 70px 15px 20px;margin: 0;}
       .tg  {border-collapse:collapse;border-spacing:0;border-color:#aaa;margin:0px auto;}
       .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#333;background-color:#fff;}
       .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aaa;color:#fff;background-color:#f38630;}
       .tg .tg-unidades{background-color:#FCFBE3;vertical-align:top; border-bottom: hidden}
       .tg .tg-sc3x{font-weight:bold;background-color:#f38630;text-align:center;vertical-align:top}
       .tg .tg-zczf{background-color:#FCFBE3;text-align:right;vertical-align:top; border-bottom: hidden}
       .tg .tg-lqy6{text-align:right;vertical-align:top; border-bottom: hidden}
       .tg .tg-yw4l{vertical-align:top; border-bottom: hidden}
       .tg .tg-titulo1{font-weight:bold;text-align:right;vertical-align:top}
       .tg .tg-titulo2{background-color:#FCFBE3;font-weight:bold;vertical-align:top}
       .tg .tg-hgcj{font-weight:bold;text-align:center}
       .tg .tg-tajt{font-weight:bold;background-color:#ffcc67;text-align:center;vertical-align:top}
</style>


<table class="tg">
  <tr>
    <th class="tg-hgcj" colspan="2" rowspan="2">Unidades<br>Orc.</th>
    <th class="tg-sc3x" colspan="24">Elementos de Despesa</th>
  </tr>
  <tr>
    <td class="tg-titulo1">3.1.90.11</td>
    <td class="tg-titulo2">3.1.90.13</td>
    <td class="tg-titulo1">3.1.90.16</td>
    <td class="tg-titulo2">3.1.90.91</td>
    <td class="tg-titulo1">3.1.90.94</td>
    <td class="tg-titulo2">3.3.50.41</td>
    <td class="tg-titulo1">3.3.90.18</td>
    <td class="tg-titulo2">3.3.90.35</td>
    <td class="tg-titulo1">3.3.90.37</td>
    <td class="tg-titulo2">3.3.90.91</td>
    <td class="tg-titulo1">3.3.90.93</td>
    <td class="tg-titulo2">3.4.90.14</td>
    <td class="tg-titulo1">3.4.90.30</td>
    <td class="tg-titulo2">3.4.90.33</td>
    <td class="tg-titulo1">3.4.90.36</td>
    <td class="tg-titulo2">3.4.90.39</td>
    <td class="tg-titulo1">3.4.90.47</td>
    <td class="tg-titulo2">4.5.90.51</td>
    <td class="tg-titulo1">4.5.90.52</td>
    <td class="tg-titulo2">4.6.90.61</td>
    <td class="tg-titulo1">4.6.90.64</td>
    <td class="tg-titulo2">Total</td>
  </tr>

      <?php
                 $query_unidades = "SELECT DISTINCT moda_nomeunidade, moda_codunidade FROM modeloa_moda, ano_an WHERE moda_codano = 6 AND moda_codano = an_codano";

                    $unidades = ModeloA::findBySql($query_unidades)->all(); 

              foreach ($unidades as $unidade) {
                     $nome_unidade = $unidade['moda_nomeunidade'];
                     $cod_unidade  = $unidade['moda_codunidade'];

                      //Localiza os centros de custos das unidades que serão selecionas acima
                      $query_unidades = "SELECT moda_centrocusto FROM modeloa_moda, ano_an WHERE moda_codunidade = '".$cod_unidade."' AND moda_codano = 6 AND moda_codano = an_codano";

                    $unidades = ModeloA::findBySql($query_unidades)->all(); 

              foreach ($unidades as $unidade) {
                     $centro_custo = $unidade['moda_centrocusto'];
                }
      ?>
  <tr>
    <td class="tg-yw4l"><?php echo $centro_custo[12].$centro_custo[13]; ?></td>
    <td class="tg-unidades"><?php echo $nome_unidade ?></td>


        <?php
                 $totalgeral_programado = 0;
                 $totalgeral_reforco = 0;
                 $totalgeral_dotacao = 0;
                 
                 $total_programado_corrente = 0;
                 $total_reforco_corrente = 0;
                 $total_dotacao_corrente = 0;
                 
                 $query_orcamentos = "SELECT orcpro_identificacao, orcpro_codigo, orcpro_titulo FROM orcamentoprograma_orcpro ORDER BY orcpro_codorcpro";

                         $orcamentos = OrcamentoPrograma::findBySql($query_orcamentos)->all(); 

              foreach ($orcamentos as $orcamento) {

                     $codigo_orcamento = $orcamento['orcpro_codigo'];
                     $identificacao    = $orcamento['orcpro_identificacao'];
                     $titulo           = $orcamento['orcpro_titulo'];
                 
                     $acumula_programado = 0;
                     $acumula_reforco = 0;

                        
                        $query_detalhesmodelo = "SELECT deta_identificacao, deta_programado, deta_reforcoreducao FROM detalhesmodeloa_deta, modeloa_moda WHERE deta_identificacao = '".$identificacao."' AND deta_codmodelo = moda_codmodelo AND moda_codunidade = '".$cod_unidade."' AND moda_codano = 6 ORDER BY deta_identificacao";

                         $detalhesmodelo = DetalhesModeloA::findBySql($query_detalhesmodelo)->all(); 

              foreach ($detalhesmodelo as $detalhemodelo) {

                     $programado = $detalhemodelo['deta_programado'];
                     $reforco    = $detalhemodelo['deta_reforcoreducao'];

                     $acumula_programado = $acumula_programado + $programado;
                     $acumula_reforco = $acumula_reforco + $reforco;

                     $total_programado_corrente = $total_programado_corrente + $programado;
                     $total_reforco_corrente    = $total_reforco_corrente + $reforco;
                     $total_dotacao_corrente    = $total_dotacao_corrente + ( $programado + $reforco);
                                          
                     $totalgeral_programado = $totalgeral_programado + $programado;
                     $totalgeral_reforco    = $totalgeral_reforco + $reforco;
                     $totalgeral_dotacao    = $totalgeral_dotacao + ( $programado + $reforco);

                     }
        ?> 
    <td class="tg-lqy6"><?php echo number_format($acumula_programado + $acumula_reforco,2,".",".");?></td>

      <?php
        }
      ?>
 <td class="tg-lqy6"><strong><?php echo number_format($totalgeral_dotacao,2,".",".");?></strong></td>

     <?php
       }
      ?>

  </tr>

  <tr>
    <td class="tg-tajt" colspan="2">Total</td>
            <?php
                 $totalgeral_programado = 0;
                 $totalgeral_reforco = 0;
                 $totalgeral_dotacao = 0;
                 
                 $total_programado_corrente = 0;
                 $total_reforco_corrente = 0;
                 
                 $query_orcamentos = "SELECT orcpro_identificacao, orcpro_codigo, orcpro_titulo FROM orcamentoprograma_orcpro ORDER BY orcpro_codorcpro";

                         $orcamentos = OrcamentoPrograma::findBySql($query_orcamentos)->all(); 

              foreach ($orcamentos as $orcamento) {

                     $codigo_orcamento = $orcamento['orcpro_codigo'];
                     $identificacao    = $orcamento['orcpro_identificacao'];
                     $titulo           = $orcamento['orcpro_titulo'];
                 
                     $total_elemento = 0;
                    
                        $query_detalhesmodelo = "SELECT deta_identificacao, deta_programado, deta_reforcoreducao FROM detalhesmodeloa_deta, modeloa_moda WHERE deta_identificacao = '".$identificacao."' AND deta_codmodelo = moda_codmodelo AND moda_codano = 6 ORDER BY deta_identificacao";

                         $detalhesmodelo = DetalhesModeloA::findBySql($query_detalhesmodelo)->all(); 

              foreach ($detalhesmodelo as $detalhemodelo) {


                     $programado = $detalhemodelo['deta_programado'];
                     $reforco    = $detalhemodelo['deta_reforcoreducao'];

                     $acumula_programado = $acumula_programado + $programado;
                     $acumula_reforco = $acumula_reforco + $reforco;

                     $total_elemento += $programado + $reforco;
                     }
        ?> 

     <td class="tg-tajt"><?php echo number_format($total_elemento,2,".",".");?></td>

     <?php
       }
      ?>

    </tr>
</table>