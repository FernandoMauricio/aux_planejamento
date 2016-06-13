<?php

namespace app\controllers\solicitacoes;

use Yii;

use app\models\base\Emailusuario;
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

            $totalGeral = $model->matc_totalValorMono + $model->matc_totalValorColor;


         $model->situacao_id = 2;
         if($model->situacao_id == 2){

             //ENVIANDO EMAIL PARA O USUÁRIO INFORMANDO SOBRE UMA NOVA MENSAGEM....
              $sql_email = "SELECT emus_email FROM `db_base`.emailusuario_emus WHERE emus_codusuario = '".$model->matc_solicitante."'";
          
          $email_solicitacao = Emailusuario::findBySql($sql_email)->all(); 
          foreach ($email_solicitacao as $email)
              {
                $email_usuario  = $email["emus_email"];

                                Yii::$app->mailer->compose()
                                ->setFrom(['dep.suporte@am.senac.br' => 'DEP - INFORMA'])
                                ->setTo($email_usuario)
                                ->setSubject('Aprovada! - Solicitação de Cópia '.$model->matc_id.'')
                                ->setTextBody('Por favor, verique a situação da solicitação de cópia de código: '.$model->matc_id.' com status de '.$model->situacao->sitmat_descricao.' ')
                                ->setHtmlBody('<p>Prezado(a), Senhor(a)</p>

                                <p>A solicitação de cópia de código <span style="color:rgb(247, 148, 29)"><strong>'.$model->matc_id.'</strong></span> foi atualizada:</p>

                                <p><strong>Situação</strong>: '.$model->situacao->sitmat_descricao.'</p>

                                <p><strong>Material</strong>: '.$model->matc_descricao.'</p>

                                <p><strong>Total de Despesa</strong>: R$ ' .number_format($totalGeral, 2, ',', '.').'</p>

                                <p><strong>Responsável pela Aprovação</strong>: '.$model->matc_autorizacao.'</p>

                                <p><strong>Data/Hora da Autorização</strong>: '.date('d/m/Y H:i', strtotime($model->matc_dataAut)).'</p>

                                <p>Por favor, não responda esse e-mail. Acesse http://portalsenac.am.senac.br</p>

                                <p>Atenciosamente,</p>

                                <p>Divisão de Educação Profissional - DEP</p>')
                                ->send();
                   } 

               }

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

            $totalGeral = $model->matc_totalValorMono + $model->matc_totalValorColor;


         $model->situacao_id = 3;
         if($model->situacao_id == 3){

             //ENVIANDO EMAIL PARA O USUÁRIO INFORMANDO SOBRE UMA NOVA MENSAGEM....
              $sql_email = "SELECT emus_email FROM `db_base`.emailusuario_emus WHERE emus_codusuario = '".$model->matc_solicitante."'";
          
          $email_solicitacao = Emailusuario::findBySql($sql_email)->all(); 
          foreach ($email_solicitacao as $email)
              {
                $email_usuario  = $email["emus_email"];

                                Yii::$app->mailer->compose()
                                ->setFrom(['dep.suporte@am.senac.br' => 'DEP - INFORMA'])
                                ->setTo($email_usuario)
                                ->setSubject('Reprovada! - Solicitação de Cópia '.$model->matc_id.'')
                                ->setTextBody('Por favor, verique a situação da solicitação de cópia de código: '.$model->matc_id.' com status de '.$model->situacao->sitmat_descricao.' ')
                                ->setHtmlBody('<p>Prezado(a), Senhor(a)</p>

                                <p>A solicitação de cópia de código <span style="color:rgb(247, 148, 29)"><strong>'.$model->matc_id.'</strong></span> foi atualizada:</p>

                                <p><strong>Situação</strong>: '.$model->situacao->sitmat_descricao.'</p>

                                <p><strong>Material</strong>: '.$model->matc_descricao.'</p>

                                <p><strong>Total de Despesa</strong>: R$ ' .number_format($totalGeral, 2, ',', '.').'</p>

                                <p><strong>Responsável pela Reprovação</strong>: '.$model->matc_autorizacao.'</p>

                                <p><strong>Data/Hora da Autorização</strong>: '.date('d/m/Y H:i', strtotime($model->matc_dataAut)).'</p>

                                <p>Por favor, não responda esse e-mail. Acesse http://portalsenac.am.senac.br</p>

                                <p>Atenciosamente,</p>

                                <p>Divisão de Educação Profissional - DEP</p>')
                                ->send();
                   } 

               }

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
