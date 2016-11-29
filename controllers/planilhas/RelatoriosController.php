<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\cadastros\Ano;
use app\models\cadastros\Tipoplanilha;
use app\models\planilhas\Planilhadecurso;
use app\models\planilhas\PlanilhadecursoSearch;
use app\models\cadastros\Situacaoplanilha;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;


class RelatoriosController extends Controller
{

    public function actionRelatorio()
    {
    	$model = new Planilhadecurso();

    	$ano 			  = Ano::find()->orderBy(['an_codano'=>SORT_DESC])->all();
    	$situacaoPlanilha = Situacaoplanilha::find()->all();
    	$tipoPlanilha 	  = Tipoplanilha::find()->all();

        return $this->render('/relatorios/relatorio', [
        	'model'			   => $model,
        	'ano'			   => $ano,
        	'situacaoPlanilha' => $situacaoPlanilha,
        	'tipoPlanilha'	   => $tipoPlanilha,
        	]);

    }
}