<?php

namespace app\controllers\relatorios;

use Yii;
use app\models\base\Unidade;
use app\models\cadastros\Ano;
use app\models\relatorios\RelatoriosDep;
use app\models\planos\Planodeacao;
use app\models\planilhas\Planilhadecurso;
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
                        `planilhadecurso_placu`.`placu_anoexercicio`,
                        `categoriaplanilha_cat`.`cat_descricao`,
                        `planilhadecurso_placu`.`placu_quantidadeturmas`,
                        `planilhadecurso_placu`.`placu_cargahorariaplano`,
                        (`planilhadecurso_placu`.`placu_quantidadeturmas` * `planilhadecurso_placu`.`placu_cargahorariaplano`) AS CH_TOTAL,
                        (`planilhadecurso_placu`.`placu_cargahorariaplano` * (`planilhadecurso_placu`.`placu_quantidadealunos` + `planilhadecurso_placu`.`placu_quantidadealunospsg` + `planilhadecurso_placu`.`placu_quantidadealunosisentos`)) AS CHALUNO,
                        `planilhadecurso_placu`.`placu_quantidadealunos`,
                        `planilhadecurso_placu`.`placu_quantidadealunospsg`,
                        `planilhadecurso_placu`.`placu_quantidadealunosisentos`,
                        (`planilhadecurso_placu`.`placu_quantidadealunos` + `planilhadecurso_placu`.`placu_quantidadealunospsg` + `planilhadecurso_placu`.`placu_quantidadealunosisentos`) AS MAT_TOTAL
                    FROM 
                        `planilhadecurso_placu` 
                        INNER JOIN `eixo_eix` ON `planilhadecurso_placu`.`placu_codsegmento` = `eixo_eix`.`eix_codeixo` 
                        INNER JOIN `segmento_seg` ON `planilhadecurso_placu`.`placu_codeixo` = `segmento_seg`.`seg_codeixo` 
                        INNER JOIN `tipodeacao_tip` ON `planilhadecurso_placu`.`placu_codtipoa` = `tipodeacao_tip`.`tip_codtipoa` 
                        INNER JOIN `planodeacao_plan` ON `planilhadecurso_placu`.`placu_codplano` = `planodeacao_plan`.`plan_codplano` 
                        INNER JOIN `nivel_niv` ON `planilhadecurso_placu`.`placu_codnivel` = `nivel_niv`.`niv_codnivel`
                        INNER JOIN `categoriaplanilha_cat` ON `planilhadecurso_placu`.`placu_codcategoria` = `categoriaplanilha_cat`.`cat_codcategoria`
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
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(10);
            $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(10);

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
             ->setCellValue('J1', 'CH TURMAS')
             ->setCellValue('K1', 'CH TOTAL')
             ->setCellValue('L1', 'CHALUNO')
             ->setCellValue('M1', 'MAT PAG')
             ->setCellValue('N1', 'MAT PSG')
             ->setCellValue('O1', 'MAT ISE')
             ->setCellValue('P1', 'MAT TOTAL');
                 
         $row=2; //GERAÇÃO DOS DADOS A PARTIR DA LINHA 2
                                
                foreach ($foos as $foo) {  
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$foo['placu_nomeunidade']);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$foo['eix_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$foo['seg_descricao']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$foo['tip_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$foo['plan_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$foo['niv_sigla']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$foo['placu_anoexercicio']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$foo['cat_descricao']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$foo['placu_quantidadeturmas']);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$foo['placu_cargahorariaplano']);
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$row,$foo['CH_TOTAL']);
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$row,$foo['CHALUNO']);
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$row,$foo['placu_quantidadealunos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$row,$foo['placu_quantidadealunospsg']);
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$row,$foo['placu_quantidadealunosisentos']);
                    $objPHPExcel->getActiveSheet()->setCellValue('P'.$row,$foo['MAT_TOTAL']);

                    $row++ ;
               }

        header('Content-Type: application/vnd.ms-excel');
        $filename = "Relatoio_PAAR_".date("d-m-Y-His").".xls";
        header('Content-Disposition: attachment;filename='.$filename .' ');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');      

    }
}
