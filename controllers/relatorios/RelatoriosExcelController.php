<?php

namespace app\controllers\relatorios;

use Yii;
use app\models\base\Unidade;
use app\models\cadastros\Ano;
use app\models\relatorios\RelatoriosDep;
use app\models\planos\Planodeacao;
use app\models\planilhas\Planilhadecurso;
use app\models\relatorios\RelatorioItensConsumo;
use app\models\relatorios\RelatorioPlanilhasPrecificacao;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;



class RelatoriosExcelController extends Controller
{

    public function behaviors()
    {

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionGerarRelatorio()
    {
    
        return $this->render('/relatorios/relatorios-excel/gerar-relatorio');

    }

    public function actionExcelPaar()
    {

        $objPHPExcel = new \PHPExcel();

        $sheet=0;
                  
            $objPHPExcel->setActiveSheetIndex($sheet);

                $connection = Yii::$app->db_apl;
                $command = $connection->createCommand('
                   SELECT 
                        `planilhadecurso_placu`.`placu_nomeunidade`,
                        `eixo_eix`.`eix_descricao`,
                        `segmento_seg`.`seg_descricao`, 
                        `tipodeacao_tip`.`tip_descricao`,
                        `planodeacao_plan`.`plan_descricao`,
                        `nivel_niv`.`niv_sigla`,
                        `ano_an`.`an_ano`,
                        `categoriaplanilha_cat`.`cat_descricao`,
                        `planilhadecurso_placu`.`placu_quantidadeturmas`,
                        `planilhadecurso_placu`.`placu_anoexercicio`,
                        (`planilhadecurso_placu`.`placu_cargahorariaarealizar` + `planilhadecurso_placu`.`placu_cargahorariavivencia`) AS CH_TURMA,
                        (`planilhadecurso_placu`.`placu_quantidadeturmas` * `planilhadecurso_placu`.`placu_cargahorariaplano`) AS CH_TURMATOTAL,
                        (`planilhadecurso_placu`.`placu_cargahorariaplano` * (`planilhadecurso_placu`.`placu_quantidadealunos` + `planilhadecurso_placu`.`placu_quantidadealunospsg` + `planilhadecurso_placu`.`placu_quantidadealunosisentos`)) AS CHALUNO,
                        `planilhadecurso_placu`.`placu_quantidadeturmas` * (`planilhadecurso_placu`.`placu_cargahorariaplano` * (`planilhadecurso_placu`.`placu_quantidadealunos` + `planilhadecurso_placu`.`placu_quantidadealunospsg` + `planilhadecurso_placu`.`placu_quantidadealunosisentos`)) AS CH_ALUNOTOTAL,
                        `planilhadecurso_placu`.`placu_quantidadealunos` * `planilhadecurso_placu`.`placu_quantidadeturmas` AS MAT_PAG,
                        `planilhadecurso_placu`.`placu_quantidadealunospsg` * `planilhadecurso_placu`.`placu_quantidadeturmas` AS MAT_PSG,
                        `planilhadecurso_placu`.`placu_quantidadealunosisentos` * `planilhadecurso_placu`.`placu_quantidadeturmas` AS MAT_ISE,
                        `planilhadecurso_placu`.`placu_quantidadeturmas` * (`planilhadecurso_placu`.`placu_quantidadealunos` + `planilhadecurso_placu`.`placu_quantidadealunospsg` + `planilhadecurso_placu`.`placu_quantidadealunosisentos`) AS MAT_TOTAL,
                        `planilhadecurso_placu`.`placu_quantidadeturmas` * `planilhadecurso_placu`.`placu_cargahorariaarealizar` * `planilhadecurso_placu`.`placu_quantidadealunos` AS CH_ALUNOPAG,
                        `planilhadecurso_placu`.`placu_quantidadeturmas` * `planilhadecurso_placu`.`placu_cargahorariaarealizar` * `planilhadecurso_placu`.`placu_quantidadealunospsg` AS CH_ALUNOPSG,
                        `planilhadecurso_placu`.`placu_quantidadeturmas` * `planilhadecurso_placu`.`placu_cargahorariaarealizar` * `planilhadecurso_placu`.`placu_quantidadealunosisentos` AS CH_ALUNOISE,
                        `tipoprogramacao_tipro`.`tipro_descricao`
                    FROM 
                        `planilhadecurso_placu` 
                        INNER JOIN `ano_an` ON `planilhadecurso_placu`.`placu_codano` = `ano_an`.`an_codano`
                        INNER JOIN `eixo_eix` ON `planilhadecurso_placu`.`placu_codeixo` = `eixo_eix`.`eix_codeixo`
                        INNER JOIN `segmento_seg` ON `planilhadecurso_placu`.`placu_codeixo` = `segmento_seg`.`seg_codeixo` 
                        INNER JOIN `tipodeacao_tip` ON `planilhadecurso_placu`.`placu_codtipoa` = `tipodeacao_tip`.`tip_codtipoa` 
                        INNER JOIN `planodeacao_plan` ON `planilhadecurso_placu`.`placu_codplano` = `planodeacao_plan`.`plan_codplano` 
                        INNER JOIN `nivel_niv` ON `planilhadecurso_placu`.`placu_codnivel` = `nivel_niv`.`niv_codnivel`
                        INNER JOIN `categoriaplanilha_cat` ON `planilhadecurso_placu`.`placu_codcategoria` = `categoriaplanilha_cat`.`cat_codcategoria`
                        INNER JOIN `tipoprogramacao_tipro` ON `tipoprogramacao_tipro`.`tipro_codprogramacao` = `planilhadecurso_placu`.`placu_codprogramacao`
                    WHERE 
                        `planilhadecurso_placu`.`placu_codsituacao` = 4
                    AND `seg_codsegmento` = `placu_codsegmento`
                    ');

                $foos = $command->queryAll();

            //TAMANHO DAS COLUNAS  
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(10);

            //TÍTULO DAS COLUNAS
            $objPHPExcel->getActiveSheet()->setTitle('EXCEL-PAAR')                     
             ->setCellValue('A1', 'UNIDADE')
             ->setCellValue('B1', 'EIXO')
             ->setCellValue('C1', 'SEGMENTO')
             ->setCellValue('D1', 'TIPO')
             ->setCellValue('E1', 'PLANO')
             ->setCellValue('F1', 'NÍVEL')
             ->setCellValue('G1', 'ANO')
             ->setCellValue('H1', 'FINANCIAMENTO')
             ->setCellValue('I1', 'QUANT. TURMAS')
             ->setCellValue('J1', 'EXERCICIO')
             ->setCellValue('K1', 'CH TURMA')
             ->setCellValue('L1', 'CH TURMA TOTAL')
             ->setCellValue('M1', 'CH ALUNO')
             ->setCellValue('N1', 'CH ALUNO TOTAL')
             ->setCellValue('O1', 'MAT PAG')
             ->setCellValue('P1', 'MAT PSG')
             ->setCellValue('Q1', 'MAT ISE')
             ->setCellValue('R1', 'MAT TOTAL')
             ->setCellValue('S1', 'CH ALUNO PAG')
             ->setCellValue('T1', 'CH ALUNO PSG')
             ->setCellValue('U1', 'CH ALUNO ISE')
             ->setCellValue('V1', 'PROGRAMÇÃO');
                 
         $row=2; //GERAÇÃO DOS DADOS A PARTIR DA LINHA 2
                                
                foreach ($foos as $foo) {  
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['placu_nomeunidade']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['eix_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['seg_descricao']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['tip_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['plan_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['niv_sigla']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['an_ano']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$foo['cat_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$foo['placu_quantidadeturmas']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$foo['placu_anoexercicio']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$foo['CH_TURMA']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$foo['CH_TURMATOTAL']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,$foo['CHALUNO']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,$foo['CH_ALUNOTOTAL']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,$foo['MAT_PAG']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,$foo['MAT_PSG']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row,$foo['MAT_ISE']);
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row,$foo['MAT_TOTAL']);
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row,$foo['CH_ALUNOPAG']);
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row,$foo['CH_ALUNOPSG']);
                    $objPHPExcel->getActiveSheet()->setCellValue('U'.$row,$foo['CH_ALUNOISE']);
                    $objPHPExcel->getActiveSheet()->setCellValue('V'.$row,$foo['tipro_descricao']);

                    $row++ ;
               }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Relatorio_PAAR_".date("d-m-Y-His").".xls";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');      

    }

    public function actionGerarRelatorioItensConsumo()
    {
        $model = new RelatorioItensConsumo();
        $ano = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();

        if ($model->load(Yii::$app->request->post())) {
            $objPHPExcel = new \PHPExcel();
            $sheet=0;
            $objPHPExcel->setActiveSheetIndex($sheet);

                $connection = Yii::$app->db_apl;
                $command = $connection->createCommand('
                    SELECT
                        `planilhadecurso_placu`.`placu_nomeunidade`,
                        `planilhaconsumo_planico`.`planico_codMXM`,
                        `segmento_seg`.`seg_descricao`,
                        `planilhaconsumo_planico`.`planico_descricao`,
                        `planilhaconsumo_planico`.`planico_tipo`,
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CE - MANOEL CATHARINO DOS SANTOS GOMES - CIN",`planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "CIN",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CENTRO DE TURISMO E HOSPITALIDADE - CTH",`planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "CTH",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - JOSE TADROS - JT", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "JT",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - FERNANDO ALFREDO PEQUENO FRANCO - PF", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "PF",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "FACULDADE DE TECNOLOGIA SENAC - FATESE", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "FATESE",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - LAZARO DA SILVA REIS - LSR", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "LSR",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - MOYSES BENARROS ISRAEL - MBI", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "MBI",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - MATHEUS PENNA RIBEIRO - MPR", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "MPR",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - LILI BENCHIMOL - LB", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "LB",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - PROFESSOR JEFFERSON PERES - PJP", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "PJP",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "BALSA ESCOLA", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "BALSA_ESCOLA",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CARRETA DE BELEZA", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "CARRETA_BELEZA",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CARRETA DE TURISMO E HOSPITALIDADE", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "CARRETA_HOSPITALIDADE",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CARRETA DE INFORMATICA", `planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "CARRETA_INFORMATICA",
                        ROUND(SUM(`planilhaconsumo_planico`.`planico_quantidade` * `planilhadecurso_placu`.`placu_quantidadeturmas`), 2) AS "QUANTIDADE_TOTAL",
                        `planilhaconsumo_planico`.`planico_valor` AS "VALOR_UNITARIO"
                    FROM 
                        `planilhadecurso_placu` 
                    LEFT JOIN 
                        `planilhaconsumo_planico` ON `planilhadecurso_placu`.`placu_codplanilha` = `planilhaconsumo_planico`.`planilhadecurso_cod`
                    LEFT JOIN 
                        `segmento_seg` ON `planilhadecurso_placu`.`placu_codsegmento` = `segmento_seg`.`seg_codsegmento` 
                    WHERE 
                        `planilhadecurso_placu`.`placu_codsituacao` = 4 
                        AND `planilhaconsumo_planico`.`planico_descricao` IS NOT NULL 
                        AND `planilhadecurso_placu`.`placu_codano` =  '.$_POST['RelatorioItensConsumo']['relat_codano'].'
                    GROUP BY 
                        `planilhaconsumo_planico`.`planico_descricao`
                    ORDER BY 
                        `planilhaconsumo_planico`.`planico_descricao` ASC
                    ');

                $foos = $command->queryAll();

            //TAMANHO DAS COLUNAS  
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);


            //TÍTULO DAS COLUNAS
            $objPHPExcel->getActiveSheet()->setTitle('EXCEL-PAAR')                     
             ->setCellValue('A1', 'COD. MXM')
             ->setCellValue('B1', 'SEGMENTO')
             ->setCellValue('C1', 'DESCRIÇÃO')
             ->setCellValue('D1', 'TIPO')
             ->setCellValue('E1', 'CIN')
             ->setCellValue('F1', 'CTH')
             ->setCellValue('G1', 'CEP-JT')
             ->setCellValue('H1', 'CEP-PF')
             ->setCellValue('I1', 'FATESE')
             ->setCellValue('J1', 'CEP-LSR')
             ->setCellValue('K1', 'CEP-MBI')
             ->setCellValue('L1', 'CEP-MPR')
             ->setCellValue('M1', 'CEP-LB')
             ->setCellValue('N1', 'CEP-PJP')
             ->setCellValue('O1', 'UMF')
             ->setCellValue('P1', 'CARRETA DE BELEZA')
             ->setCellValue('Q1', 'CARRETA DE HOSPITALIDADE')
             ->setCellValue('R1', 'CARRETA DE INFORMÁTICA')
             ->setCellValue('S1', 'QUANTIDADE')
             ->setCellValue('T1', 'VALOR_UNITARIO');
                 
         $row=2; //GERAÇÃO DOS DADOS A PARTIR DA LINHA 2
                                
                foreach ($foos as $foo) {  
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['planico_codMXM']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['seg_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['planico_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['planico_tipo']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['CIN']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['CTH']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['JT']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$foo['PF']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$foo['FATESE']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$foo['LSR']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$foo['MBI']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$foo['MPR']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,$foo['LB']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,$foo['PJP']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,$foo['BALSA_ESCOLA']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,$foo['CARRETA_BELEZA']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row,$foo['CARRETA_HOSPITALIDADE']);
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row,$foo['CARRETA_INFORMATICA']);
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row,$foo['QUANTIDADE_TOTAL']);
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row,$foo['VALOR_UNITARIO']);

                    $row++ ;
                }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Relatorio_Itens_Consumo".date("d-m-Y-His").".xls";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');      

    }else{
        return $this->renderAjax('gerar-relatorio-itens-consumo', [
           'model'    => $model,
           'ano'      => $ano,
           ]);
        }
    }

    public function actionGerarRelatorioItensMaterialDidatico()
    {
        $model = new RelatorioItensConsumo();
        $ano = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();

        if ($model->load(Yii::$app->request->post())) {
            $objPHPExcel = new \PHPExcel();
            $sheet=0;
            $objPHPExcel->setActiveSheetIndex($sheet);

                $connection = Yii::$app->db_apl;
                $command = $connection->createCommand('
                    SELECT
                        `planilhadecurso_placu`.`placu_nomeunidade`,
                        `planilhamaterial_planima`.`planima_codmxm`,
                        `planilhamaterial_planima`.`planima_titulo`,
                        `planilhamaterial_planima`.`planima_editora`,
                        `planilhamaterial_planima`.`planima_tipomaterial`,
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CE - MANOEL CATHARINO DOS SANTOS GOMES - CIN", 1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "CIN",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CENTRO DE TURISMO E HOSPITALIDADE - CTH", 1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "CTH",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - JOSE TADROS - JT",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "JT",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - FERNANDO ALFREDO PEQUENO FRANCO - PF",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "PF",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "FACULDADE DE TECNOLOGIA SENAC - FATESE",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "FATESE",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - LAZARO DA SILVA REIS - LSR",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "LSR",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - MOYSES BENARROS ISRAEL - MBI",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "MBI",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - MATHEUS PENNA RIBEIRO - MPR",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "MPR",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - LILI BENCHIMOL - LB",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "LB",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CEP - PROFESSOR JEFFERSON PERES - PJP",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "PJP",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "BALSA ESCOLA",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "BALSA_ESCOLA",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CARRETA DE BELEZA",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "CARRETA_BELEZA",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CARRETA DE TURISMO E HOSPITALIDADE",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "CARRETA_HOSPITALIDADE",
                        ROUND(SUM(IF(`planilhadecurso_placu`.`placu_nomeunidade` = "CARRETA DE INFORMATICA",  1 * `planilhadecurso_placu`.`placu_quantidadeturmas`, 0)), 2) AS "CARRETA_INFORMATICA",
                        ROUND(SUM( 1 * `planilhadecurso_placu`.`placu_quantidadeturmas`), 2) AS "QUANTIDADE_TOTAL",
                        `planilhamaterial_planima`.`planima_valor` AS "VALOR_UNITARIO"
                    FROM 
                        `planilhadecurso_placu` 
                    LEFT JOIN 
                        `planilhamaterial_planima` ON `planilhadecurso_placu`.`placu_codplanilha` = `planilhamaterial_planima`.`planilhadecurso_cod`
                    LEFT JOIN 
                        `segmento_seg` ON `planilhadecurso_placu`.`placu_codsegmento` = `segmento_seg`.`seg_codsegmento` 
                    WHERE 
                        `planilhadecurso_placu`.`placu_codsituacao` = 4 
                        AND`planilhamaterial_planima`.`planima_titulo` IS NOT NULL 
                        AND `planilhadecurso_placu`.`placu_codano` = '.$_POST['RelatorioItensConsumo']['relat_codano'].'
                    GROUP BY 
                       `planilhamaterial_planima`.`planima_titulo`
                    ORDER BY 
                        `planilhamaterial_planima`.`planima_titulo` ASC
                    ');

                $foos = $command->queryAll();

            //TAMANHO DAS COLUNAS  
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(50);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);


            //TÍTULO DAS COLUNAS
            $objPHPExcel->getActiveSheet()->setTitle('EXCEL-PAAR')                     
             ->setCellValue('A1', 'COD. MXM')
             ->setCellValue('B1', 'DESCRIÇÃO')
             ->setCellValue('C1', 'EDITORA')
             ->setCellValue('D1', 'TIPO_MATERIAL')
             ->setCellValue('E1', 'CIN')
             ->setCellValue('F1', 'CTH')
             ->setCellValue('G1', 'CEP-JT')
             ->setCellValue('H1', 'CEP-PF')
             ->setCellValue('I1', 'FATESE')
             ->setCellValue('J1', 'CEP-LSR')
             ->setCellValue('K1', 'CEP-MBI')
             ->setCellValue('L1', 'CEP-MPR')
             ->setCellValue('M1', 'CEP-LB')
             ->setCellValue('N1', 'CEP-PJP')
             ->setCellValue('O1', 'UMF')
             ->setCellValue('P1', 'CARRETA DE BELEZA')
             ->setCellValue('Q1', 'CARRETA DE HOSPITALIDADE')
             ->setCellValue('R1', 'CARRETA DE INFORMÁTICA')
             ->setCellValue('S1', 'QUANTIDADE')
             ->setCellValue('T1', 'VALOR_UNITARIO');
                 
         $row=2; //GERAÇÃO DOS DADOS A PARTIR DA LINHA 2
                                
                foreach ($foos as $foo) {  
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['planima_codmxm']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['planima_titulo']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['planima_editora']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['planima_tipomaterial']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['CIN']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['CTH']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['JT']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$foo['PF']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$foo['FATESE']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$foo['LSR']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$foo['MBI']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$foo['MPR']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,$foo['LB']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,$foo['PJP']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,$foo['BALSA_ESCOLA']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,$foo['CARRETA_BELEZA']);
                    $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row,$foo['CARRETA_HOSPITALIDADE']);
                    $objPHPExcel->getActiveSheet()->setCellValue('R'.$row,$foo['CARRETA_INFORMATICA']);
                    $objPHPExcel->getActiveSheet()->setCellValue('S'.$row,$foo['QUANTIDADE_TOTAL']);
                    $objPHPExcel->getActiveSheet()->setCellValue('T'.$row,$foo['VALOR_UNITARIO']);

                    $row++ ;
                }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Relatorio_Itens_Material_Didatico".date("d-m-Y-His").".xls";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');      

    }else{
        return $this->renderAjax('gerar-relatorio-itens-material-didatico', [
           'model'    => $model,
           'ano'      => $ano,
           ]);
        }
    }

    public function actionGerarRelatorioPlanilhasPrecificacao()
    {
        $model = new RelatorioPlanilhasPrecificacao();
        $ano = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();

        if ($model->load(Yii::$app->request->post())) {
            $objPHPExcel = new \PHPExcel();
            $sheet=0;
            $objPHPExcel->setActiveSheetIndex($sheet);

                $connection = Yii::$app->db_apl;
                $command = $connection->createCommand('
                    SELECT  planp_ano, 
                            plan_descricao,
                            planp_cargahoraria, 
                            planp_mesesdocurso, 
                            planp_qntaluno, 
                            planp_totalhorasdocente, 
                            planp_docente
                    FROM precificacao_planp 
                    INNER JOIN `planodeacao_plan` ON `precificacao_planp`.`planp_planodeacao` = `planodeacao_plan`.`plan_codplano` 
                    WHERE planp_ano = '.$_POST['RelatorioPlanilhasPrecificacao']['relat_codano'].'
                    ');

                $foos = $command->queryAll();

            //TAMANHO DAS COLUNAS  
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);

            //TÍTULO DAS COLUNAS
            $objPHPExcel->getActiveSheet()->setTitle('EXCEL-PAAR')                     
             ->setCellValue('A1', 'ANO')
             ->setCellValue('B1', 'PLANO')
             ->setCellValue('C1', 'CH')
             ->setCellValue('D1', 'MESES DO CURSO')
             ->setCellValue('E1', 'QNT ALUNO')
             ->setCellValue('F1', 'TOTAL HORAS DOCENTE')
             ->setCellValue('G1', 'DOCENTE');
             // ->setCellValue('H1', 'CEP-PF')
             // ->setCellValue('I1', 'FATESE')
             // ->setCellValue('J1', 'CEP-LSR')
             // ->setCellValue('K1', 'CEP-MBI')
             // ->setCellValue('L1', 'CEP-MPR')
             // ->setCellValue('M1', 'CEP-LB')
             // ->setCellValue('N1', 'CEP-PJP')
             // ->setCellValue('O1', 'UMF')
             // ->setCellValue('P1', 'CARRETA DE BELEZA')
             // ->setCellValue('Q1', 'CARRETA DE HOSPITALIDADE')
             // ->setCellValue('R1', 'CARRETA DE INFORMÁTICA')
             // ->setCellValue('S1', 'QUANTIDADE')
             // ->setCellValue('T1', 'VALOR_UNITARIO');
                 
         $row=2; //GERAÇÃO DOS DADOS A PARTIR DA LINHA 2
                                
                foreach ($foos as $foo) {  
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['planp_ano']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['plan_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['planp_cargahoraria']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['planp_mesesdocurso']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['planp_qntaluno']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['planp_totalhorasdocente']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['planp_docente']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$foo['PF']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$foo['FATESE']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$foo['LSR']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$foo['MBI']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$foo['MPR']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,$foo['LB']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,$foo['PJP']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,$foo['BALSA_ESCOLA']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,$foo['CARRETA_BELEZA']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('Q'.$row,$foo['CARRETA_HOSPITALIDADE']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('R'.$row,$foo['CARRETA_INFORMATICA']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('S'.$row,$foo['QUANTIDADE_TOTAL']);
                    // $objPHPExcel->getActiveSheet()->setCellValue('T'.$row,$foo['VALOR_UNITARIO']);

                    $row++ ;
                }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Relatorio_Planilha_Precificacao".date("d-m-Y-His").".xls";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');      

    }else{
        return $this->renderAjax('gerar-relatorio-planilhas-precificacao', [
           'model'    => $model,
           'ano'      => $ano,
           ]);
        }
    }
}