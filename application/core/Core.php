<?php

namespace application\core;

use application\database\Database;
use application\exceptions\RouteException;
use application\helpers\DirectoryHelper;
use application\router\Router;

/**
 * Class Core
 * @package Application
 */
class Core
{

    const DEFAULT_CONTROLLER_NAME = 'Site';
    const DEFAULT_ACTION_NAME = 'index';
    const ACTION_PREFIX = 'action';

    private $router;
    private $controllersDirName = 'Controllers';
    private $request;

    /**
     * Core constructor.
     * @param Router $router
     */
    public function __construct(Router $router, $config)
    {
        $this->router = $router;
        Database::loadParams($config);

        $this->request = new \stdClass();
        $this->request->get = $_GET ? (object)$_GET : null;
        $this->request->post = $_POST ? (object)$_POST : null;

    }


    /**
     * @return mixed|string
     */
    public function launch()
    {
        list($controllerName, $actionName, $params) = $this->router->resolve();

        try {
            return $this->launchAction($controllerName, $actionName, $params);
        } catch (RouteException $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param $controllerName
     * @param $actionName
     * @param $params
     * @return mixed
     * @throws RouteException
     */
    private function launchAction($controllerName, $actionName, $params)
    {
        $controller = $this->loadController($controllerName);

        $action = empty($actionName) ? $this->getActionName(self::DEFAULT_ACTION_NAME) : $this->getActionName($actionName);

        if (!method_exists($controller, $action)) {
            throw new RouteException("Action {$actionName} not found in {$controllerName}", 404);
        }

        return $controller->$action($params);
    }

    /**
     * @param $controllerName
     * @return mixed
     * @throws RouteException
     */
    private function loadController($controllerName)
    {
        $controllerName = empty($controllerName) ? self::DEFAULT_CONTROLLER_NAME : ucfirst($controllerName);

        $fileName = DirectoryHelper::getRootDirectory() . $this->controllersDirName
            . DIRECTORY_SEPARATOR . $controllerName . 'Controller.php';

        if (!file_exists($fileName)) {
            throw new RouteException("Controller {$controllerName} not found", 404);
        }

        $controllerName = "\\{$this->controllersDirName}\\" .
            ucfirst($controllerName) . 'Controller';

        return new $controllerName($this->request);
    }

    /**
     * @param $value
     * @return string
     */
    private function getActionName($value)
    {
        return self::ACTION_PREFIX . ucfirst($value);
    }

}