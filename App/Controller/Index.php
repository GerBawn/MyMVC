<?php
namespace App\Controller;

use App\Model\User;

class Index
{
    public function index()
    {
        $model = new User();
        $model->createUser(['name' => 'aaa', 'age' => 15]);
        $model->createUser(['name' => 'bbb']);
        var_dump($model->getAllUser());
    }
}