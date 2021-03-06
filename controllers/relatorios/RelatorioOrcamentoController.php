<?php

namespace app\controllers\relatorios;

use Yii;
use app\models\base\Unidade;
use app\models\cadastros\Ano;
use app\models\relatorios\RelatorioModeloB;
use app\models\planilhas\Planilhadecurso;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;


class RelatorioOrcamentoController extends Controller
{

    public function behaviors()
    {

        $this->AccessAllow(); //Irá ser verificado se o usuário está logado no sistema

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
        $model = new RelatorioModeloB();

        $ano = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();

        if ($model->load(Yii::$app->request->post())) {

                return $this->redirect(['relatorio-unidades-elemento-despesa', 'combo_ano' => $model->relat_codano]);
        }else{

                return $this->render('/relatorios/relatorio-orcamento/gerar-relatorio', [
                    'model'            => $model,
                    'ano'              => $ano,
                    ]);
            }
    }

    public function actionRelatorioUnidadesElementoDespesa($combo_ano) 
    {
       $this->layout = 'main-imprimir';
        $combo_ano   = $this->findModelAnoPlanilha($combo_ano);

           return $this->render('/relatorios/relatorio-orcamento/relatorio-unidades-elemento-despesa', [
              'combo_ano'         => $combo_ano, 
              ]);
    }

    protected function findModelAnoPlanilha($combo_ano)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$combo_ano."'";

        if (($combo_ano = Ano::findBySql($queryAno)->one()) !== null) {
            return $combo_ano;
        } else {
            throw new NotFoundHttpException('A página solicitada não existe.');
        }
    }

    public function AccessAllow()
    {
        $session = Yii::$app->session;
        if (!isset($session['sess_codusuario']) && !isset($session['sess_codcolaborador']) && !isset($session['sess_codunidade']) && !isset($session['sess_nomeusuario']) && !isset($session['sess_coddepartamento']) && !isset($session['sess_codcargo']) && !isset($session['sess_cargo']) && !isset($session['sess_setor']) && !isset($session['sess_unidade']) && !isset($session['sess_responsavelsetor'])) 
        {
           return $this->redirect('https://portalsenac.am.senac.br');
        }
    }
}