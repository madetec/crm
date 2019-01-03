<?php

namespace madetec\crm\controllers;

use madetec\crm\forms\ChangePasswordForm;
use madetec\crm\services\UserManageService;
use Yii;
use yii\web\Controller;

/**
 * Default controller for the `admin` module
 */
class DefaultController extends Controller
{

    private $manage;

    public function __construct(string $id, $module, UserManageService $userManageService, array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->manage = $userManageService;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        return $this->redirect(['client/index']);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionChangePassword()
    {
        $form = new ChangePasswordForm();

        if($form->load(Yii::$app->request->post()) && $form->validate()){
            try{
              $this->manage->changePassword(Yii::$app->user->getId(),$form);
              Yii::$app->session->setFlash('success','Пароль успешно заменен');
             return $this->redirect(['client/index']);
            }catch (\Exception $e){
                Yii::$app->session->setFlash('error',$e->getMessage());
            }
        }

        return $this->render('change_password',[
            'model' => $form
        ]);
    }


}
