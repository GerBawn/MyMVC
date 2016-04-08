<?php
namespace App\Controller;

use Predis\Client;
use System\Core\Controller;
use System\Libraries\Log;

class Index extends Controller
{
    public function index()
    {
        $this->cache->set('name', 'lingchen');
        var_dump($this->cache->get('name'));
        Log::write('DEBUG', 'my name is lingchen');
    }
}