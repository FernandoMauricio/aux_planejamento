<?php

namespace app\controllers\planilhas;

use Yii;
use app\models\base\Unidade;
use app\models\despesas\Despesasdocente;
use app\models\despesas\Custosunidade;
use app\models\planos\Planodeacao;
use app\models\planilhas\Precificacao;
use app\models\planilhas\PrecificacaoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * PrecificacaoController implements the CRUD actions for Precificacao model.
 */
class PrecificacaoController extends Controller
{
    /**
     * @inheritdoc
     */
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

    /**
     * Lists all Precificacao models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PrecificacaoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Precificacao model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    //Localiza os dados de custos indiretos da unidade escolhida
    public function actionGetCustoUnidade($custounidade){

        $getcustoUnidade = Custosunidade::find()->where(['cust_codunidade' => $custounidade])->one();

        echo Json::encode($getcustoUnidade);
    }


    //Localiza os dados do Plano
    public function actionGetPlano($plano){

        $getPlano = Planodeacao::find()->where(['plan_codplano' => $plano])->one();

        echo Json::encode($getPlano);
    }

    //Localiza os dados de nível de docente
    public function actionGetNivelDocente($niveldocente){

        $getnivelDocente = Despesasdocente::find()->where(['doce_id' => $niveldocente])->one();

        echo Json::encode($getnivelDocente);
    }

    /**
     * Creates a new Precificacao model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Precificacao();

        $planos       = Planodeacao::find()->where(['plan_status' => 1])->orderBy('plan_descricao')->all();
        $unidades     = Unidade::find()->where(['uni_codsituacao' => 1, 'uni_coddisp' => 1])->orderBy('uni_nomeabreviado')->all();
        $nivelDocente = Despesasdocente::find()->where(['doce_status' => 1])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->planp_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'planos' => $planos,
                'unidades' => $unidades,
                'nivelDocente' => $nivelDocente,
            ]);
        }
    }

    /**
     * Updates an existing Precificacao model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->planp_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Precificacao model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Precificacao model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Precificacao the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Precificacao::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}