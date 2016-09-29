<?php

namespace app\controllers\despesas;

use Yii;
use app\models\despesas\Despesasdocente;
use app\models\despesas\DespesasdocenteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DespesasdocenteController implements the CRUD actions for Despesasdocente model.
 */
class DespesasdocenteController extends Controller
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
     * Lists all Despesasdocente models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DespesasdocenteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Despesasdocente model.
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
     * Creates a new Despesasdocente model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Despesasdocente();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($model->calculos == 1) { // Realiza os cálculos de Planejamento e Produtividade caso seja marcado a opção
                $model->doce_planejamento = $model->doce_valor + $model->doce_dsr; //Planejamento = Valor + DSR
                $model->doce_produtividade = ($model->doce_valor * 45) / 100; //Produtividade = Valor * 45%
                $model->doce_valorhoraaula = $model->doce_valor + $model->doce_dsr + $model->doce_produtividade; // Valor Hora Aula = valor + DSR + Produtividade
                $model->save();
            }else{

                $model->doce_valorhoraaula = $model->doce_valor + $model->doce_dsr;
                $model->save();
            }

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Despesa com docente cadastrada!</strong>');

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Despesasdocente model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->doce_planejamento  = 0;
        $model->doce_produtividade = 0;
        $model->doce_valorhoraaula = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if($model->calculos == 1) { // Realiza os cálculos de Planejamento e Produtividade caso seja marcado a opção
                $model->doce_planejamento = $model->doce_valor + $model->doce_dsr; //Planejamento = Valor + DSR
                $model->doce_produtividade = ($model->doce_valor * 45) / 100; //Produtividade = Valor * 45%
                $model->doce_valorhoraaula = $model->doce_valor + $model->doce_dsr + $model->doce_produtividade; // Valor Hora Aula = valor + DSR + Produtividade
                $model->save();
            }else{

                $model->doce_valorhoraaula = $model->doce_valor + $model->doce_dsr;
                $model->save();
            }

            Yii::$app->session->setFlash('success', '<strong>SUCESSO! </strong> Despesa com docente atualizada!</strong>');

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Despesasdocente model.
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
     * Finds the Despesasdocente model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Despesasdocente the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Despesasdocente::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
