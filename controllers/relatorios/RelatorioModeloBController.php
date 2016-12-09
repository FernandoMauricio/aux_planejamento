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


class RelatorioModeloBController extends Controller
{
    public function actionGerarRelatorio()
    {
	    $model = new RelatorioModeloB();

	    $unidades = Unidade::find()->where(['uni_codsituacao' => 1])->orderBy('uni_nomeabreviado')->all();
	    $ano      = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();

        if ($model->load(Yii::$app->request->post())) {

                return $this->redirect(['relatorio-modelo-b', 'combo_unidade' => $model->relat_unidade, 'combo_ano' => $model->relat_codano]);
        }else{

	            return $this->render('/relatorios/relatorio-modelo-b/gerar-relatorio', [
	                'model'            => $model,
	                'unidades'         => $unidades,
	                'ano'              => $ano,
	                ]);
	        }
    }

    public function actionRelatorioModeloB($combo_unidade, $combo_ano)
    {
       $this->layout = 'main-imprimir';
       $combo_unidade         = $this->findModelUnidade($combo_unidade);
       $combo_ano         = $this->findModelAnoPlanilha($combo_ano);

             return $this->render('/relatorios/relatorio-modelo-b/relatorio-modelo-b', [
              'combo_unidade'         => $combo_unidade,
              'combo_ano'         => $combo_ano, 
              ]);
    }

    protected function findModelUnidade($combo_unidade)
    {
        $queryUnidade = "SELECT placu_codunidade, placu_nomeunidade FROM planilhadecurso_placu WHERE placu_codunidade = '".$combo_unidade."'";

        $combo_unidade = Planilhadecurso::findBySql($queryUnidade)->one();

        return $combo_unidade;
    }

    protected function findModelAnoPlanilha($combo_ano)
    {
        $queryAno = "SELECT * FROM ano_an WHERE an_codano = '".$combo_ano."'";

        if (($combo_ano = Ano::findBySql($queryAno)->one()) !== null) {
            return $combo_ano;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}