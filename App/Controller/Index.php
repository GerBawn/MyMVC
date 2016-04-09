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
        $this->load->helper('helpers');
    }
}