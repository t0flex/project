<?php

namespace application\router;

/**
 * Class Router
 * @package Application
 */
class Router

{
    /**
     * @return mixed
     */
    public function resolve()
    {
        $route = null;

        if (($pos = strpos($_SERVER['REQUEST_URI'], '?')) !== false) {
            $route = substr($_SERVER['REQUEST_URI'], 0, $pos);
        }
        $route = is_null($route) ? $_SERVER['REQUEST_URI'] : $route;
        $route = explode('/', $route);
        array_shift($route);
        $result[] = array_shift($route);
        $result[] = array_shift($route);
        $result[] = $route;

        return $result;

    }
}