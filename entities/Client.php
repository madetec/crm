<?php

namespace madetec\crm\entities;

use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\VarDumper;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $name
 * @property string $last_name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property int $date_of_birth
 * @property string $phone
 * @property string $email
 * @property string $params
 * @property string $avatar
 * @property integer $status
 *
 * @mixin ImageUploadBehavior
 *
 * @property DealerAssignments $clientAssignments[]
 * @property DealerAssignments $dealerAssignments[]
 * @property $this $dealer
 * @property $this $clients[]
 */
class Client extends \yii\db\ActiveRecord
{
    const STATUS_DEALER = 10;
    const STATUS_CLIENT = 20;

    public static function create($name, $last_name, $address_line_1, $address_line_2, $date_of_birth, $phone, $email, $params, $avatar, $status): self
    {
        $client = new static();
        $client->name = $name;
        $client->last_name = $last_name;
        $client->address_line_1 = $address_line_1;
        $client->address_line_2 = $address_line_2;
        $client->date_of_birth = $date_of_birth;
        $client->phone = $phone;
        $client->email = $email;
        $client->params = $params;
        $client->avatar = $avatar;
        $client->avatar = $status;
        return $client;
    }

    public function edit($name, $last_name, $address_line_1, $address_line_2, $date_of_birth, $phone, $email, $params, $avatar, $status): void
    {
        $this->name = $name;
        $this->last_name = $last_name;
        $this->address_line_1 = $address_line_1;
        $this->address_line_2 = $address_line_2;
        $this->date_of_birth = $date_of_birth;
        $this->phone = $phone;
        $this->email = $email;
        $this->params = $params;
        $this->avatar = $avatar;
        $this->status = $status;
    }

    public function isDealer()
    {
        return $this->status == self::STATUS_DEALER;
    }

    public function isClient()
    {
        return $this->status == self::STATUS_CLIENT;
    }


    public function assignClient($id)
    {
        $clients = $this->clientAssignments;

        foreach ($clients as $client) {
            /**
             * @var DealerAssignments $client
             */
            if ($id && $client->isClientId($id)) {
                return;
            }
        }

        $clients[] = DealerAssignments::create(null, $id);
        $this->clientAssignments = $clients;
    }

    public function assignDealer($id)
    {
        $dealers = $this->dealerAssignments;
        foreach ($dealers as $dealer) {
            /**
             * @var DealerAssignments $dealer
             */
            if ($id && $dealer->isDealerId($id)) {
                return;
            }
        }
        $dealers[] = DealerAssignments::create($id);
        $this->dealerAssignments = $dealers;
    }

    public function getClientAssignments(): ActiveQuery
    {
        return $this->hasMany(DealerAssignments::class, ['dealer_id' => 'id']);
    }

    public function getDealerAssignments(): ActiveQuery
    {
        return $this->hasMany(DealerAssignments::class, ['client_id' => 'id']);
    }

    public function getClients(): ActiveQuery
    {
        return $this->hasMany(self::class, ['id' => 'client_id'])->via('clientAssignments');
    }

    public function getDealer()
    {
        return $this->hasOne(self::class, ['id' => 'dealer_id'])->via('dealerAssignments');
    }


    public function behaviors()
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'avatar',
                'thumbs' => [
                    'admin' => ['width' => 75, 'height' => 75],
                    'thumb' => ['width' => 300, 'height' => 300],
                ],
                'filePath' => '@uploads/store/clients/[[id]]/[[pk]].[[extension]]',
                'fileUrl' => '@uploadsUrl/store/clients/[[id]]/[[pk]].[[extension]]',
                'thumbPath' => '@uploads/cache/clients/[[id]]/[[profile]]_[[pk]].[[extension]]',
                'thumbUrl' => '@uploadsUrl/cache/clients/[[id]]/[[profile]]_[[pk]].[[extension]]',
            ],
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['clientAssignments','dealerAssignments']
            ]
        ];
    }

    /**
     * @throws \yii\base\InvalidArgumentException
     * @throws \yii\base\InvalidConfigException
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->date_of_birth = Yii::$app->formatter->asDate($this->date_of_birth, 'php:Y-m-d');
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->date_of_birth = strtotime($this->date_of_birth);
            return true;
        }
        return false;
    }

    public static function tableName()
    {
        return '{{%clients}}';
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'address_line_1' => 'Адрес 1',
            'address_line_2' => 'Адрес 2',
            'date_of_birth' => 'Дата рождения',
            'phone' => 'Тел.',
            'email' => 'Эл. Почта',
            'params' => 'Доп. информация',
            'avatar' => 'Фото',
            'status' => 'Тип клиента',
        ];
    }


}
