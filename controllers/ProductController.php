<?php

namespace madetec\crm\controllers;

use madetec\crm\entities\Category;
use madetec\crm\forms\PhotosForm;
use madetec\crm\forms\ProductForm;
use madetec\crm\readModels\ProductReadModel;
use madetec\crm\search\ProductSearch;
use madetec\crm\services\ProductManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CategoryController implements the CRUD actions for Category model.
 * @property ProductManageService $manageService
 * @property ProductReadModel $products
 */
class ProductController extends Controller
{
    public $manageService;
    public $products;

    public function __construct(
        string $id,
        $module,
        ProductManageService $manageService,
        ProductReadModel $readModel,
        array $config = []
    )
    {
        $this->manageService = $manageService;
        $this->products = $readModel;
        parent::__construct($id, $module, $config);
    }

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
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionView($id)
    {
        $product = $this->products->find($id);
        $photosForm = new PhotosForm();
        if ($photosForm->load(Yii::$app->request->post()) && $photosForm->validate()) {
            try {
                $this->manageService->addPhotos($product->id, $photosForm);
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\DomainException $e) {
                Yii::$app->errorHandler->logException($e);
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('view', [
            'product' => $product,
            'photosForm' => $photosForm,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCreate()
    {
        $form = new ProductForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $product = $this->manageService->create($form);
                Yii::$app->session->setFlash('success', 'Товар успешно добавлен!');
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', [
            'form' => $form,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionUpdate($id)
    {
        $product = $this->products->find($id);
        $form = new ProductForm($product);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->manageService->edit($product->id, $form);
                Yii::$app->session->setFlash('success', 'Товар успешно отредактировано!');
                return $this->redirect(['view', 'id' => $product->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            } catch (\Throwable $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'form' => $form,
            'product' => $product,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->manageService->remove($id);
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionActivate($id)
    {
        try {
            $this->manageService->activate($id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDraft($id)
    {
        try {
            $this->manageService->draft($id);
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
