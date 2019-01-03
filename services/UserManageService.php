<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\services;


use madetec\crm\entities\Category;
use madetec\crm\forms\CategoryForm;
use madetec\crm\forms\ChangePasswordForm;
use madetec\crm\repositories\UserRepository;
use yii\helpers\Inflector;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class UserManageService
 * @package madetec\crm\services
 * @property UserRepository $users
 */
class UserManageService
{
    private $users;

    public function __construct(UserRepository $userRepository)
    {
        $this->users = $userRepository;
    }

    public function changePassword($id, ChangePasswordForm $form)
    {
        $user = $this->users->get($id);
        $user->setPassword($form->password);
        $this->users->save($user);
    }
}