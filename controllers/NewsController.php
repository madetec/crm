<?php

namespace madetec\crm\controllers;

use madetec\crm\forms\NewsForm;
use madetec\crm\forms\NewsPhotosForm;
use madetec\crm\readModels\NewsReadModel;
use madetec\crm\search\ClientSearch;
use madetec\crm\search\NewsSearch;
use madetec\crm\services\NewsManageService;
use yii\filters\VerbFilter;
use yii\web\Controller;
use Yii;

/**
 * @property NewsManageService $manageService
 * @property NewsReadModel $news
 */

class NewsController extends Controller
{
    private $manageService;
    private $news;

    public function __construct(
        string $id,
        $module,
        NewsManageService $service,
        NewsReadModel $readModel,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->manageService = $service;
        $this->news = $readModel;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $news = $this->news->find($id);

        $photosForm = new NewsPhotosForm();
        if ($photosForm->load(Yii::$app->request->post()) && $photosForm->validate()) {
            try {
                $this->manageService->addPhotos($news->id, $photosForm);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('view', [
            'news' => $news,
            'photosForm' => $photosForm
        ]);
    }

    public function actionCreate()
    {
        $form = new NewsForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $client = $this->manageService->create($form);
                Yii::$app->session->setFlash('success', 'Новость успешно добавлено!');
                return $this->redirect(['view', 'id' => $client->id]);

            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            } catch (\Throwable $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'form' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $news = $this->news->find($id);
        $form = new NewsForm($news);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $client = $this->manageService->edit($news->id, $form);
                Yii::$app->session->setFlash('success', 'Новость успешно отредактирован!');
                return $this->redirect(['view', 'id' => $news->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            } catch (\Throwable $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'form' => $form,
            'news' => $news,
        ]);
    }

    public function actionDelete($id)
    {
        try {
            $this->manageService->remove($id);
            Yii::$app->session->setFlash('success', 'Новость успешно удален!');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        } catch (\Throwable $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }


    /**
     * @param $id
     * @param $photo_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDeletePhoto($id, $photo_id)
    {
        try {
            $this->manageService->removePhoto($id, $photo_id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @param $photo_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \DomainException
     */
    public function actionMovePhotoUp($id, $photo_id)
    {
        $this->manageService->movePhotoUp($id, $photo_id);
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @param $photo_id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \DomainException
     */
    public function actionMovePhotoDown($id, $photo_id)
    {
        $this->manageService->movePhotoDown($id, $photo_id);
        return $this->redirect(['view', 'id' => $id]);
    }
}
