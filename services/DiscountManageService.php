<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\services;


use madetec\crm\entities\Discount;
use madetec\crm\forms\DiscountForm;
use madetec\crm\repositories\DiscountRepository;
use yii\helpers\Inflector;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class CategoryManageService
 * @package madetec\crm\services
 * @property DiscountRepository $discounts
 */
class DiscountManageService
{
    private $discounts;

    public function __construct(DiscountRepository $discountRepository)
    {
        $this->discounts = $discountRepository;
    }

    /**
     * @param DiscountForm $form
     * @return Discount
     * @throws \DomainException
     */
    public function create(DiscountForm $form): Discount
    {
        $discount = Discount::create(
            $form->photo,
            $form->title,
            $form->description,
            Inflector::slug($form->title),
            $form->text,
            strtotime($form->published_at),
            strtotime($form->expired_at),
            $form->status
        );
        $this->discounts->save($discount);
        return $discount;
    }

    /**
     * @param $id
     * @param DiscountForm $form
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function edit($id, DiscountForm $form): void
    {
        $discount = $this->discounts->find($id);
        $discount->edit(
            $form->photo,
            $form->title,
            $form->description,
            Inflector::slug($form->title),
            $form->text,
            strtotime($form->published_at),
            strtotime($form->expired_at),
            $form->status
        );
        $this->discounts->save($discount);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException
     */
    public function remove($id): void
    {
        $discount = $this->discounts->find($id);
        $this->discounts->remove($discount);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function activated($id)
    {
        $discount = $this->discounts->find($id);
        $discount->activated();
        $this->discounts->save($discount);
    }

    /**
     * @param $id
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function draft($id)
    {
        $discount = $this->discounts->find($id);
        $discount->draft();
        $this->discounts->save($discount);
    }
}