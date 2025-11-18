<?php

namespace Core;
use Core\MiddleWare;

class Router
{
    public $routes = [];

    // Agrega una nueva ruta al enrutador con su URI, controlador y método HTTP
    public function add($uri, $controller, $method)
    {
        // Si el URI no comienza con BASE_URL, lo antepone automáticamente
        if (strpos($uri, BASE_URL) !== 0) {
            $uri = BASE_URL . $uri;
        }

        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null // Inicialmente, sin middleware
        ];
        return $this;
    }

    // Define una ruta para el método GET
    public function get($uri, $controller)
    {
        return $this->add($uri, $controller, 'GET');
    }

    // Define una ruta para el método POST
    public function post($uri, $controller)
    {
        return $this->add($uri, $controller, 'POST');
    }

    // Define una ruta para el método DELETE
    public function delete($uri, $controller)
    {
        return $this->add($uri, $controller, 'DELETE');
    }

    // Define una ruta para el método PATCH
    public function patch($uri, $controller)
    {
        return $this->add($uri, $controller, 'PATCH');
    }

    // Define una ruta para el método PUT
    public function put($uri, $controller)
    {
        return $this->add($uri, $controller, 'PUT');
    }
    
    // Asigna un middleware a la última ruta agregada
    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;
        return $this;
    }

    // Busca una ruta que coincida con la URI y el método proporcionado y ejecuta su controlador
    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {

                // Verifica si la ruta tiene un middleware asignado
                if ($route['middleware'] === 'guest') {
                    (new MiddleWare)->Guest();
                }
                if ($route['middleware'] === 'auth') {
                    (new MiddleWare)->Auth();
                }
                if ($route['middleware'] === 'admin') {
                    (new MiddleWare)->Admin();
                }
                if ($route['middleware'] === 'superadmin') {
                    (new MiddleWare)->SuperAdmin();
                }

                // Verifica si el controlador usa la notación 'Controlador@método' (ej: 'UserController@index')
                if (strpos($route['controller'], '@') !== false) {
                    // Divide la cadena en dos partes: [0] = nombre de la clase, [1] = nombre del método
                    list($controllerClass, $methodName) = explode('@', $route['controller']);
                    
                    // Agrega el namespace base 'Controllers\' al nombre de la clase
                    $controllerClass = 'Controllers\\' . $controllerClass;
                    
                    // Verifica si la clase del controlador existe
                    if (class_exists($controllerClass)) {
                        // Crea una nueva instancia del controlador
                        $controllerInstance = new $controllerClass();
                        
                        // Verifica si el método especificado existe en el controlador
                        if (method_exists($controllerInstance, $methodName)) {
                            // Ejecuta el método del controlador y devuelve su resultado
                            return $controllerInstance->$methodName();
                        } else {
                            // Si el método no existe, devuelve error 404
                            $this->abort(404);
                        }
                    } else {
                        // Si la clase no existe, devuelve error 404
                        $this->abort(404);
                    }
                } else {
                    // Si no usa la notación '@', asume que es una ruta directa a un archivo
                    // Usa la función basePath() para obtener la ruta absoluta del archivo
                    // Luego lo incluye y ejecuta con 'require', devolviendo su salida
                    return require basePath($route['controller']);
                }
            }
        }

        // Si no se encuentra una ruta válida, se aborta con un error 404
        $this->abort(404);
    }
    
    // Maneja los errores de rutas no encontradas
    protected function abort($code)
    {
        http_response_code($code);
        require basePath("views/error/$code.view.php");
        die();
    }
}
