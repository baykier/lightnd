<?php
/**
 * Created by PhpStorm.
 * Author: Baykier<1035666345@qq.com>
 * Date: 2016/9/9
 * Time: 15:20
 */
namespace Baykier\Lightnd\Orm;

use Masterminds\HTML5\Exception;
use \Spot\Config as AbstractConfig;

class Config
{
    protected static $config = null;
    /**
     * @config file path
     * @var string
     */
    protected static  $configFile = 'config.php';


    public static function getConfig()
    {
        $configFile = __DIR__ . '/../../config.php';
        if (!file_exists($configFile))
        {
            throw new \Exception(sprintf('The Config File %s not exits',$configFile));
        }
        $config = require_once $configFile;
        $cfg = new AbstractConfig();
        $cfg->addConnection($config['db']['driver'],$config['db']['default']);
        return $cfg;
    }
}