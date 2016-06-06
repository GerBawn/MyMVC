<?php
namespace System\Driver\Log;

class File
{
    private $config = [];

    public function __construct($config)
    {
        $this->config = array_merge($this->config, $config);
    }

    public function write($level, $message)
    {
        $time = date('Y-m-d H:i:s');

        $msg = "{$level} | {$time} | " . $message . PHP_EOL;

        $logFile = $this->config['logPath'] . '/' . $this->config['logFile'] . '_' . date('Ymd') . '.log';

        file_exists($this->config['logPath']) or mkdir($this->config['logPath'], 0755, true);

        if (!$fp = fopen($logFile, 'a+')) {
            return;
        }
        flock($fp, LOCK_EX);
        fwrite($fp, $msg);
        flock($fp, LOCK_UN);
        fclose($fp);
        chmod($logFile, 0777);
    }
}