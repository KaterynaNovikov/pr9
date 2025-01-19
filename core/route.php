<?php
class Route {
    public static function start() {
        $controllerName = DEFAULT_CONTROLLER;
        $actionName = DEFAULT_ACTION;

        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $segments = explode('/', $uri);

        if (!empty($segments[1])) {
            $controllerName = ucfirst($segments[1]);
        }
        if (!empty($segments[2])) {
            $actionName = $segments[2];
        }

        $controllerFile = 'controllers/' . $controllerName . 'Controller.php';
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
        } else {
            die("Контроллер не найден!");
        }

        $controllerClass = $controllerName . 'Controller';
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass();
            if (method_exists($controller, $actionName)) {
                $controller->$actionName();
            } else {
                die("Метод не найден!");
            }
        } else {
            die("Контроллер не найден!");
        }
    }
}
?>
