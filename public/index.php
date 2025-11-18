<?php 
// Inicia la sesión para manejar datos de usuario
session_start();

// Define la constante BASE_PATH que representa el directorio raíz del proyecto
const BASE_PATH = __DIR__ . '/../';

// Incluye el archivo de funciones generales
require BASE_PATH . 'Core/functions.php';

// Obtiene la URI actual sin parámetros de la URL
$uri = parse_url($_SERVER["REQUEST_URI"])["path"];

// Define BASE_URL extrayendo la parte correspondiente de la ruta del script
define('BASE_URL', substr(explode('public', $_SERVER["PHP_SELF"])[0], 0, -1));

// Registra automáticamente la carga de clases, buscando el archivo correspondiente
spl_autoload_register(function ($class) {
   // Convierte el namespace en ruta de directorios
   $resutl = str_replace('\\', DIRECTORY_SEPARATOR, $class);
   // Incluye el archivo correspondiente a la clase
   require basePath($resutl . '.php');
});

// Crea una instancia del enrutador
$router = new Core\Router();

// Carga el archivo de rutas para registrar las rutas definidas
$routes = require basePath('routes.php');


// Determina el método HTTP: puede ser un método sobreescrito vía _method o el método real de la petición
$method = $_POST['_method'] ?? $_SERVER["REQUEST_METHOD"];

// Ejecuta la ruta correspondiente según la URI y el método HTTP
$router->route($uri, $method);




