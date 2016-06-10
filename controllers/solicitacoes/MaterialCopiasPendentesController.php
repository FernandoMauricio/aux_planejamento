<?php

namespace app\controllers\solicitacoes;

use Yii;
use app\models\solicitacoes\MaterialCopiasPendentes;
use app\models\solicitacoes\MaterialCopiasPendentesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaterialCopiasPendentesController implements the CRUD actions for MaterialCopiasPendentes model.
 */
class MaterialCopiasPendentesController extends Controller
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
     * Lists all MaterialCopiasPendentes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaterialCopiasPendentesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MaterialCopiasPendentes model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MaterialCopiasPendentes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MaterialCopiasPendentes();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->matc_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MaterialCopiasPendentes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->matc_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionAprovar($id)
    {
        $session = Yii::$app->session;

        $model = $this->findModel($id);

        $model->matc_dataAut     = date('Y-m-d H:i:s');
        $model->matc_autorizacao = $session['sess_nomeusuario'];

            //-------atualiza a situação pra aprovado ou reprovado
            Yii::$app->db_apl->createCommand('UPDATE `materialcopias_matc` SET `situacao_id` = 2 , `matc_autorizacao` = "'.$model->matc_autorizacao.'" , `matc_dataAut` = "'.$model->matc_dataAut.'" WHERE `matc_id` = '.$model->matc_id.'')
            ->execute();

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Solicitação de Cópia de código:  <strong> '.$model->matc_id.'</strong> '.$model->situacao->sitmat_descricao.'!');
     
             return $this->redirect(['index']);
    }

    public function actionReprovar($id)
    {
        $session = Yii::$app->session;

        $model = $this->findModel($id);

        $model->matc_dataAut     = date('Y-m-d H:i:s');
        $model->matc_autorizacao = $session['sess_nomeusuario'];

            //-------atualiza a situação pra aprovado ou reprovado
            Yii::$app->db_apl->createCommand('UPDATE `materialcopias_matc` SET `situacao_id` = 3 , `matc_autorizacao` = "'.$model->matc_autorizacao.'" , `matc_dataAut` = "'.$model->matc_dataAut.'" WHERE `matc_id` = '.$model->matc_id.'')
            ->execute();

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Solicitação de Cópia de código:  <strong> '.$model->matc_id.'</strong> '.$model->situacao->sitmat_descricao.'!');
     
             return $this->redirect(['index']);
    }

    /**
     * Deletes an existing MaterialCopiasPendentes model.
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
     * Finds the MaterialCopiasPendentes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaterialCopiasPendentes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaterialCopiasPendentes::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
