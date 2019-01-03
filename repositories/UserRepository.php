<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\repositories;


use madetec\crm\entities\Category;
use madetec\crm\entities\User;
use yii\web\NotFoundHttpException;

class UserRepository
{
    /**
     * @param $id
     * @return User
     * @throws NotFoundHttpException
     */
    public function get($id): User
    {
        if(!$user = User::findOne($id))
        {
            throw new NotFoundHttpException('User not found');
        }
        return $user;
    }

    /**
     * @param User $user
     * @return User
     * @throws \DomainException
     */
    public function save(User $user): User
    {
        if(!$user->save())
        {
            throw new \DomainException('User save error');
        }
        return $user;
    }

}