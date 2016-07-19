<?php

namespace app\controllers\cadastros;

use Yii;
use app\models\base\Unidade;
use app\models\base\Departamento;
use app\models\base\Anocentrocusto;
use app\models\cadastros\Tipo;
use app\models\cadastros\Segmento;
use app\models\cadastros\Centrocusto;
use app\models\cadastros\CentrocustoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\helpers\Json;
/**
 * CentrocustoController implements the CRUD actions for Centrocusto model.
 */
class CentrocustoController extends Controller
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
     * Lists all Centrocusto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CentrocustoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Centrocusto model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    //Localiza os segmentos vinculados aos eixos
    public function actionDepartamento() {
                $out = [];
                if (isset($_POST['depdrop_parents'])) {
                    $parents = $_POST['depdrop_parents'];
                    if ($parents != null) {
                        $cat_id = $parents[0];
                        $out = Departamento::getDepartamentoSubCat($cat_id); 
                        echo Json::encode(['output'=>$out, 'selected'=>'']);
                        return;
                    }
                }
                echo Json::encode(['output'=>'', 'selected'=>'']);
            }

    /**
     * Creates a new Centrocusto model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Centrocusto();

        $segmento = Segmento::find()->where(['seg_status' => 1])->orderBy('seg_descricao')->all();
        $tipoacao = Tipo::find()->where(['tip_status' => 1])->orderBy('tip_descricao')->all();
        $unidades = Unidade::find()->where(['uni_codsituacao'=> 1])->orderBy('uni_nomecompleto')->all();
        $anocentrocusto = Anocentrocusto::find()->where(['ance_ano'=> date('Y')])->all();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cen_codcentrocusto]);
        } else {
            return $this->render('create', [
                'model' => $model,
                'segmento' => $segmento,
                'tipoacao' => $tipoacao,
                'unidades' => $unidades,
                'anocentrocusto' => $anocentrocusto,
            ]);
        }
    }

    /**
     * Updates an existing Centrocusto model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cen_codcentrocusto]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Centrocusto model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Centrocusto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Centrocusto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Centrocusto::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
