<?php


namespace App\Core;

use Monolog\Level;
use Monolog\Logger;
use Monolog\ResettableInterface;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Log implements ResettableInterface
{
    protected Logger $logger;
    /**
     * logReader.
     *
     * @access	public
     * @return	\Monolog\Logger
     */
    public function logReader(): \Monolog\Logger
    {
        // Create the logger
        $this->logger = new Logger('mii_logger');
        // Now add some handlers

        $path = 'storage/logs';
        if (!is_dir($path)) {
            mkdir($path, 0775, true);
            exec(touch($path . '/mii.log'));
        }

        $this->logger->pushHandler(new StreamHandler('storage/logs/mii.log', Level::Debug));
        $this->logger->pushHandler(new FirePHPHandler());

        return $this->logger;
    }

    public function reset(): void
    {
        $this->logger->reset();
    }
}
