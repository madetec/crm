<?php

namespace madetec\crm\controllers;

use madetec\crm\forms\OrderForm;
use madetec\crm\readModels\OrderReadModel;
use madetec\crm\search\OrderSearch;
use madetec\crm\services\OrderManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * OrderController implements the CRUD actions for Order model.
 * @property OrderManageService $manageService;
 * @property OrderReadModel $orders;
 */
class OrderController extends Controller
{
    public $manageService;
    public $orders;

    public function __construct(
        string $id,
        $module,
        OrderManageService $service,
        OrderReadModel $readModel,
        array $config = [])
    {
        $this->manageService = $service;
        $this->orders = $readModel;
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
        $searchModel = new OrderSearch();
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
            'order' => $this->orders->find($id),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCreate()
    {
        $form = new OrderForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $order = $this->manageService->create($form);
                return $this->redirect(['view', 'id' => $order->id]);
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
        $order = $this->orders->find($id);
        $form = new OrderForm($order);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $order = $this->manageService->edit($order->id, $form);
                return $this->redirect(['view', 'id' => $order->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'form' => $form,
            'order' => $order,
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

    //- status -//

    public function actionStatusNew($id)
    {
        try {
            $this->manageService->statusNew($id);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionStatusSold($id)
    {
        try {
            $this->manageService->statusSold($id);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionStatusCanceled($id)
    {
        try {
            $this->manageService->statusCanceled($id);
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }
}
