<?php

namespace app\controllers\repositorio;

use Yii;
use app\models\repositorio\Categoria;
use app\models\repositorio\Editora;
use app\models\repositorio\Tipomaterial;
use app\models\repositorio\Repositorio;
use app\models\repositorio\RepositorioMateriaisSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * RepositorioMateriaisController implements the CRUD actions for Repositorio model.
 */
class RepositorioMateriaisController extends Controller
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
     * Lists all Repositorio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RepositorioMateriaisSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Repositorio model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Repositorio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = Yii::$app->session;

        $model = new Repositorio();

        $categoria = Categoria::find()->where(['cat_status' => 1])->orderBy('cat_descricao')->all();
        $editora = Editora::find()->where(['edi_status' => 1])->orderBy('edi_descricao')->all();
        $tipomaterial = Tipomaterial::find()->where(['tip_status' => 1])->orderBy('tip_descricao')->all();

        $model->rep_data = date('Y-m-d');
        $model->rep_codunidade = $session['sess_codunidade'];
        $model->rep_codcolaborador = $session['sess_codcolaborador'];

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            // //INCLUSÃO DO ARQUIVO
            // $model->file = UploadedFile::getInstance($model, 'file');
            // if ($model->file && $model->validate()) 
            // {  
            //     $model->rep_arquivo = $model->file->baseName . '.' . $model->file->extension;
            //     $model->save();

            //     if($model->save())
            //     {
            //         if (!empty($_POST)) 
            //         {
            //               $model->file->saveAs($model->file->baseName . '.' . $model->file->extension);
            //         }   
            //     }
            // }
            ///VERIRICAR UPLOAD DO ARQUIVO
            $model->file = UploadedFile::getInstance($model, 'image');
                       if (!is_null($model->file)) {
                         $model->rep_arquivo = $model->file->baseName . '.' . $model->file->extension;
                          Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/repositorio/capas/';
                          $path = Yii::$app->params['uploadPath'] . $model->file;
                           $model->file->saveAs($path);

                        }
              //INCLUSÃO DA CAPA
            $image = UploadedFile::getInstance($model, 'image');
                       if (!is_null($image)) {
                         $model->image_src_filename = $image->name;
                         $ext = end((explode(".", $image->name)));
                          // generate a unique file name to prevent duplicate filenames
                          $model->image_web_filename = Yii::$app->security->generateRandomString().".{$ext}";
                          // the path to save file, you can set an uploadPath
                          // in Yii::$app->params (as used in example below)                       
                          Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/repositorio/capas/';
                          $path = Yii::$app->params['uploadPath'] . $model->image_web_filename;
                           $image->saveAs($path);
                        }
                        if ($model->save()) {             
                            return $this->redirect(['view', 'id' => $model->rep_codrepositorio]);       
                        }  else {
                            var_dump ($model->getErrors()); die();
                         }
                } 
            return $this->render('create', [
                'model' => $model,
                'categoria' => $categoria,
                'editora' => $editora,
                'tipomaterial' => $tipomaterial,
            ]);
    }

    /**
     * Updates an existing Repositorio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $session = Yii::$app->session;

        $model = $this->findModel($id);

        $categoria = Categoria::find()->where(['cat_status' => 1])->orderBy('cat_descricao')->all();
        $editora = Editora::find()->where(['edi_status' => 1])->orderBy('edi_descricao')->all();
        $tipomaterial = Tipomaterial::find()->where(['tip_status' => 1])->orderBy('tip_descricao')->all();

        $model->rep_data = date('Y-m-d');
        $model->rep_codunidade = $session['sess_codunidade'];
        $model->rep_codcolaborador = $session['sess_codcolaborador'];
        $model->file = $model->rep_arquivo;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            //INCLUSÃO DO ARQUIVO
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) 
            {  
                $model->rep_arquivo = 'uploads/repositorio/' . $model->file->baseName . '.' . $model->file->extension;
                $model->save();

                if($model->save())
                {
                    if (!empty($_POST)) 
                    {
                          $model->file->saveAs('uploads/repositorio/' . $model->file->baseName . '.' . $model->file->extension);
                    }   
                }
            }  

            return $this->redirect(['view', 'id' => $model->rep_codrepositorio]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'categoria' => $categoria,
                'editora' => $editora,
                'tipomaterial' => $tipomaterial,
            ]);
        }
    }

    /**
     * Deletes an existing Repositorio model.
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
     * Finds the Repositorio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Repositorio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Repositorio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
