<?php

namespace madetec\crm\controllers;

use madetec\crm\forms\ClientForm;
use madetec\crm\forms\DealerAssignmentForm;
use madetec\crm\readModels\ClientReadModel;
use madetec\crm\search\ClientSearch;
use madetec\crm\services\ClientManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ClientController implements the CRUD actions for Client model.
 * @property ClientManageService $manageService;
 * @property ClientReadModel $clients;
 */
class ClientController extends Controller
{
    private $manageService;
    private $clients;

    public function __construct(
        string $id,
        $module,
        ClientManageService $service,
        ClientReadModel $readModel,
        array $config = []
    )
    {
        parent::__construct($id, $module, $config);
        $this->manageService = $service;
        $this->clients = $readModel;
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
        $searchModel = new ClientSearch();
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
        $client = $this->clients->find($id);
        $form = new DealerAssignmentForm($client);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->manageService->assign($client->id, $form);
                Yii::$app->session->setFlash('success', 'Операция успешно выполнена!');
                $this->refresh();
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('view', [
            'client' => $client,
            'model' => $form,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCreate()
    {
        $form = new ClientForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $client = $this->manageService->create($form);
                Yii::$app->session->setFlash('success', 'Клиент добавлен успешно!');
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

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionUpdate($id)
    {
        $client = $this->clients->find($id);
        $form = new ClientForm($client);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $client = $this->manageService->edit($client->id, $form);
                Yii::$app->session->setFlash('success', 'Клиент успешно редактирован!');
                return $this->redirect(['view', 'id' => $client->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            } catch (\Throwable $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('update', [
            'form' => $form,
            'client' => $client,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDelete($id)
    {
        try {
            $this->manageService->remove($id);
            Yii::$app->session->setFlash('success', 'Клиент успешно удален!');
        } catch (\Exception $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        } catch (\Throwable $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }
}
