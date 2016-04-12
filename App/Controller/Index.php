<?php
namespace App\Controller;

use App\Model\User;
use Predis\Client;
use System\Core\Controller;
use System\Libraries\Log;

class Index extends Controller
{
    public function index()
    {
        $user = new User();
        var_dump($user->getOneUser());
        var_dump($user->createUser(['name' => 'lingchen', 'age' => 23]));
    }
}