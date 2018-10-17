<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace madetec\crm\forms;

use madetec\crm\entities\Client;
use yii\web\UploadedFile;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class ClientForm
 * @package madetec\crm\forms
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
 */
class ClientForm extends CompositeForm
{

    public $name;
    public $last_name;
    public $address_line_1;
    public $address_line_2;
    public $date_of_birth;
    public $phone;
    public $email;
    public $params;
    public $avatar;
    public $status;

    public $clients;

    public $_client;

    public function __construct(Client $client = null, array $config = [])
    {
        if ($client) {
            $this->name = $client->name;
            $this->last_name = $client->last_name;
            $this->address_line_1 = $client->address_line_1;
            $this->address_line_2 = $client->address_line_2;
            $this->date_of_birth = $client->date_of_birth;
            $this->phone = $client->phone;
            $this->email = $client->email;
            $this->params = $client->params;
            $this->avatar = $client->avatar;
            $this->status = $client->status;
            $this->_client = $client;
        }
        parent::__construct($config);
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date_of_birth'], 'date', 'format' => 'php:Y-m-d'],
            [['status'], 'integer'],
            [['params'], 'string'],
            ['email', 'email'],
            [['name', 'last_name', 'address_line_1', 'address_line_2', 'phone'], 'string', 'max' => 255],
            ['avatar', 'file', 'extensions' => 'jpeg, gif, png, jpg'],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->avatar = UploadedFile::getInstance($this, 'avatar');
            return true;
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'address_line_1' => 'Адрес 1',
            'address_line_2' => 'Адрес 2',
            'date_of_birth' => 'Дата родждения',
            'phone' => 'Тел.',
            'email' => 'Эл. Почта',
            'params' => 'Доп. информация',
            'avatar' => 'Фото',
            'status' => 'Тип клиента',
        ];
    }


    public function internalForms(): array
    {
        return [];
    }
}