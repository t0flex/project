<?php

namespace application;

use application\core\Core;
use application\router\Router;

/**
 * Class App
 * @package Application
 */
class App
{

    private $router;
    private $core;

    /**
     * App constructor.
     * @param $config
     */
    public function __construct($config)
    {
        spl_autoload_register(['static', 'loadClass']);
        $this->router = new Router();
        $this->core = new Core($this->router, $config);

    }

    /**
     * @return mixed|string
     */
    public function init()
    {
        return $this->core->launch();
    }

    /**
     * @param $className
     */
    private static function loadClass($className)
    {
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        require_once(dirname(__DIR__) . '/' . $className . '.php');
    }

}