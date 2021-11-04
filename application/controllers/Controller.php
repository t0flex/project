<?php

namespace application\controllers;

use application\helpers\DirectoryHelper;

/**
 * Class Controller
 * @package Application
 */
class Controller
{
    protected $request;

    public $layoutFile = 'main';

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * @param $content
     * @return string
     */
    public function renderLayout($content, $params)
    {
        ob_start();
        extract($params);
        require DirectoryHelper::getRootDirectory() . 'views' . DIRECTORY_SEPARATOR . 'layout' . DIRECTORY_SEPARATOR . $this->layoutFile . '.php';
        return ob_get_flush();
    }

    /**
     * @param $view
     * @param array $params
     * @return string
     */
    public function render($view, array $params = [])
    {
        $viewFile = DirectoryHelper::getRootDirectory() . 'views' . DIRECTORY_SEPARATOR . $view . '.php';
        extract($params);
        ob_start();
        require $viewFile;
        $content = ob_get_clean();
        ob_end_clean();

        return $this->renderLayout($content, $params);
    }

    /**
     * @param $controller
     * @param string $method
     */
    public function redirect($controller = null, $method = null)
    {
        $location = '';

        if ($controller && $method) {
            $location = ucfirst($controller) . "/" . ucfirst($method);
        }

        return header("Location: " . '/'.$location);
    }
}