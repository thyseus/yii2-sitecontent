<?php

namespace thyseus\sitecontent\controllers;

use thyseus\sitecontent\models\Sitecontent;
use thyseus\sitecontent\models\SitecontentSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SitecontentController implements the CRUD actions for Sitecontent model.
 */
class SitecontentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
                        'matchCallback' => Yii::$app->getModule('sitecontent')->accessCallback,
                    ],
                    [
                        'allow' => true,
                        'actions' => ['view'],
                        'roles' => ['?', '@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Sitecontent models.
     * @var $tree set to true to display an Tree View. Filtering is disabled then, though :-(
     * @return mixed
     */
    public function actionIndex($tree = false)
    {
        $searchModel = new SitecontentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'tree' => $tree,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sitecontent model.
     * If the sitecontent is available in another language than requested, a redirection to the correct page is
     * being returned.
     * @param string $id
     * @param string $language
     * @return mixed
     */
    public function actionView($id, $language = null)
    {
        if (!$language) {
            $language = Yii::$app->language;
        }

        if ($layout = Yii::$app->getModule('sitecontent')->layout) {
            $this->layout = $layout;
        }

        $model = $this->findModel($id, $language);

        if ($target = $this->redirectionNecessary($model, $id, $language)) {
            return $this->redirect($target, 301);
        }

        if ($model->status != Sitecontent::STATUS_PUBLIC) {
            throw new NotFoundHttpException();
        }

        $model->updateCounters(['views' => 1]);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Sitecontent model.
     * May fall back to a not requested language if slug or id is equivalent.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @param string $language
     * @return Sitecontent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $language = null)
    {
        if (!$language) {
            $language = Yii::$app->language;
        }

        if (($model = Sitecontent::findOne(['slug' => $id, 'language' => $language])) !== null) {
            return $model;
        } else if (($model = Sitecontent::findOne(['id' => $id, 'language' => $language])) !== null) {
            return $model;
        } else if (($model = Sitecontent::findOne(['id' => $id])) !== null) {
            return $model;
        } else if (($model = Sitecontent::findOne(['slug' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Check if an redirection is necessary for the given sitecontent. If so, return the route to the correct target.
     * @param $model model to check against
     * @param $id id to check against
     * @param $language language to check against
     * @return array
     */
    protected function redirectionNecessary($model, $id, $language)
    {
        if ($model->language != $language && $correct_model = Sitecontent::findOne(['id' => $model->id, 'language' => $language])) {
            return ['//sitecontent/sitecontent/view', 'id' => $correct_model->slug];
        }
    }

    /**
     * Creates a new Sitecontent model.
     * If creation is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     */
    public function actionCreate($source_id = null, $source_language = null, $target_language = null)
    {
        $model = new Sitecontent();

        if ($source_id && $source_language) {
            if ($source = Sitecontent::find()->where(['id' => $source_id, 'language' => $source_language])->one()) {
                $model->attributes = $source->attributes;
            } else {
                throw new NotFoundHttpException('The source sitecontent could not be found');
            }

            if ($target_language) {
                $model->language = $target_language;
            }
        }

        if (!$model->id) {
            $model->id = Sitecontent::nextFreeId();
        }

        $model->views = 0;
        $model->status = 0;

        if (!$model->language && isset(Yii::$app->language))
            $model->language = Yii::$app->language;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sitecontent model.
     * If update is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $language
     * @return mixed
     */
    public function actionUpdate($id, $language = null)
    {
        $model = $this->findModel($id, $language);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('form', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sitecontent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @param string $language
     * @return mixed
     */
    public function actionDelete($id, $language)
    {
        $this->findModel($id, $language)->delete();

        return $this->redirect(['index']);
    }
}
