<?php

namespace madetec\crm\controllers;

use madetec\crm\forms\WarrantyAssignmentForm;
use madetec\crm\forms\warrantyForm;
use madetec\crm\readModels\WarrantyReadModel;
use madetec\crm\search\WarrantySearch;
use madetec\crm\services\WarrantyManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * warrantyController implements the CRUD actions for warranty model.
 * @property WarrantyManageService $manageService;
 * @property WarrantyReadModel $warranties;
 */
class WarrantyController extends Controller
{
    public $manageService;
    public $warranties;

    public function __construct(
        string $id,
        $module,
        WarrantyManageService $service,
        WarrantyReadModel $readModel,
        array $config = [])
    {
        $this->manageService = $service;
        $this->warranties = $readModel;
        parent::__construct($id, $module, $config);
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

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel = new WarrantySearch();
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
        $warranty = $this->warranties->find($id);
        $form = new WarrantyAssignmentForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->manageService->assign($warranty->id, $form);
                Yii::$app->session->setFlash('success', 'Очередной гарантийный осмотр прошел успешно!');
                return $this->redirect(['view', 'id' => $warranty->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getTraceAsString());
            }
        }
        return $this->render('view', [
            'warranty' => $warranty,
            'warrantyAssignmentForm' => $form,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCreate()
    {
        $form = new WarrantyForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $warranty = $this->manageService->create($form);
                return $this->redirect(['view', 'id' => $warranty->id]);
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
        $warranty = $this->warranties->find($id);
        $form = new WarrantyForm($warranty);

        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->manageService->edit($warranty->id, $form);
                return $this->redirect(['view', 'id' => $warranty->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'form' => $form,
            'warranty' => $warranty,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
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


    public function actionRemoveAssign($warranty_id, $assign_id)
    {
        try {
            $this->manageService->removeAssign($warranty_id, $assign_id);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['view', 'id' => $warranty_id]);
    }
}
