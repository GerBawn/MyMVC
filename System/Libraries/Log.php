<?php
/**
 * User: GerBawn
 * Date: 2016/4/7
 * Time: 15:39
 */
namespace System\Libraries;

use System\Core\Application;

class Log
{
    private $path;

    private $logFile;

    private $logLevel = ['ERROR' => 1, 'DEBUG' => 2, 'INFO' => 3, 'ALL' => 4];

    private $threshold;

    public function __construct()
    {
        $app = Application::getInstance();
        $this->path = $app->config['logPath'] ? $app->config['logPath'] : BASEDIR.'/logs';
        $this->logFile = $app->config['logFile'] ? $app->config['logFile'] : 'common';
        $this->threshold = $app->config['logLevel'] ? $this->logLevel[$app->config['logLevel']] : 1;
    }

    public function write($level, $message, $class = '', $function ='', $line = '')
    {
        if($this->logLevel[$level] > $this->threshold)
            return ;
        $logFile = $this->path.'/'.$this->logFile.date('Ymd').'.log';

        file_exists($this->path) or mkdir($this->path, 0755, true);

        $time = date('Y-m-d H:i:s');

        $msg = "{$level} - {$time} - class: {$class} function:{$function} line:{$line}"
                    ." --> msg:{$message}".PHP_EOL;

        if(!$fp = fopen($logFile, 'a+'))
            return ;
        flock($fp, LOCK_EX);
        fwrite($fp, $msg);
        flock($fp, LOCK_UN);
        fclose($fp);
        chmod($logFile, 0777);
    }
}