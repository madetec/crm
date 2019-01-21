<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\services;


use madetec\crm\entities\News;
use madetec\crm\forms\NewsForm;
use madetec\crm\forms\NewsPhotosForm;
use madetec\crm\repositories\NewsRepository;

/**
 * @property NewsRepository $news
 */
class NewsManageService
{
    private $news;

    public function __construct(NewsRepository $newsRepository)
    {
        $this->news = $newsRepository;
    }


    public function create(NewsForm $form): News
    {
        $news = News::create(
            $form->title,
            $form->description,
            $form->text,
            strtotime($form->published_at),
            $form->status
        );
        if (is_array($form->photos->files)) {
            foreach ($form->photos->files as $file) {
                $news->addPhoto($file);
            }
        }
        $this->news->save($news);
        return $news;
    }

    public function edit($id, NewsForm $form): void
    {
        $news = $this->news->find($id);
        $news->edit(
            $form->title,
            $form->description,
            $form->text,
            strtotime($form->published_at),
            $form->status
        );



        $this->news->save($news);
    }

    public function remove($id): void
    {
        $news = $this->news->find($id);
        $this->news->remove($news);
    }

    /**
     * @param $id
     * @param NewsPhotosForm $form
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function addPhotos($id, NewsPhotosForm $form): void
    {
        $news = $this->news->find($id);
        foreach ($form->files as $file) {
            $news->addPhoto($file);
        }
        $this->news->save($news);
    }

    /**
     * @param $id
     * @param $photoId
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function movePhotoUp($id, $photoId): void
    {
        $news = $this->news->find($id);
        $news->movePhotoUp($photoId);
        $this->news->save($news);
    }

    /**
     * @param $id
     * @param $photoId
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function movePhotoDown($id, $photoId): void
    {
        $news = $this->news->find($id);
        $news->movePhotoDown($photoId);
        $this->news->save($news);
    }

    /**
     * @param $id
     * @param $photoId
     * @throws \DomainException
     * @throws \yii\web\NotFoundHttpException
     */
    public function removePhoto($id, $photoId): void
    {
        $news = $this->news->find($id);
        $news->removePhoto($photoId);
        $this->news->save($news);
    }
}