<?php

namespace madetec\crm\controllers;

use madetec\crm\entities\Discount;
use madetec\crm\forms\DiscountForm;
use madetec\crm\readModels\DiscountReadModel;
use madetec\crm\search\DiscountSearch;
use madetec\crm\services\DiscountManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * DiscountController implements the CRUD actions for Discount model.
 * @property DiscountManageService $manageService
 * @property DiscountReadModel $discounts
 */
class DiscountController extends Controller
{
    public $manageService;
    public $discounts;

    public function __construct(
        string $id,
        $module,
        DiscountManageService $service,
        DiscountReadModel $readModel,
        array $config = []
    )
    {
        $this->manageService = $service;
        $this->discounts = $readModel;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'activated' => ['POST'],
                    'draft' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
                'file-delete' => [
                    'class' => 'vova07\imperavi\actions\DeleteFileAction',
                    'url' => Yii::getAlias('@uploadsUrl/cache/discounts/text/'),
                    'path' => '@uploads/cache/discounts/text',
                ],
                'images-get' => [
                    'class' => 'vova07\imperavi\actions\GetImagesAction',
                    'url' => Yii::getAlias('@uploadsUrl/cache/discounts/text/'),
                    'path' => '@uploads/cache/discounts/text',
                    'options' => ['only' => ['*.jpg', '*.jpeg', '*.png', '*.gif', '*.ico']],
                ],
                'image-upload' => [
                    'class' => 'vova07\imperavi\actions\UploadFileAction',
                    'url' => Yii::getAlias('@uploadsUrl/cache/discounts/text'),
                    'path' => '@uploads/cache/discounts/text',
                ],

            ];
    }

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel = new DiscountSearch();
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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCreate()
    {
        $form = new DiscountForm();

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $discount = $this->manageService->create($form);
                Yii::$app->session->setFlash('success', 'Акция успешно добавлена!');
                return $this->redirect(['view', 'id' => $discount->id]);
            }catch (\Exception $e) {
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
        $discount = $this->discounts->find($id);
        $form = new DiscountForm($discount);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->manageService->edit($discount->id, $form);
                Yii::$app->session->setFlash('success', 'Акция успешно отредактирована!');
                return $this->redirect(['view', 'id' => $discount->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            } catch (\Throwable $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'form' => $form,
            'discount' => $discount,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        try {
            $this->manageService->remove($id);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    public function actionActivated($id)
    {
        try {
            $this->manageService->activated($id);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionDraft($id)
    {
        try {
            $this->manageService->draft($id);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Finds the Discount model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Discount the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Discount::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
