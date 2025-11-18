<?php
// Comprueba si la URL actual coincide con la proporcionada
function urlIs($url)
{
    return $_SERVER["REQUEST_URI"] === BASE_URL . $url;
}

// Depura una variable y detiene la ejecución del script
function dd($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
}

// Devuelve la ruta absoluta de un directorio o archivo basado en BASE_PATH
function basePath($path)
{
    return BASE_PATH . $path;
}


// Devuelve la ruta absoluta de la vistas
function views($path)
{
    return basePath('views/' . $path);
}


// Genera una URL absoluta basada en BASE_URL
function Url($url)
{
    return BASE_URL . $url;
}

// Genera una URL relativa basada en la sesión
function urlRelative($path)
{
    return $_SESSION["BASE_URL"] . $path;
}

// Envía un código de respuesta HTTP y carga una vista de error
function abort($code)
{
    http_response_code($code);
    require basePath("views/error/$code.view.php");
    die();
}

// Verifica si una condición de autorización se cumple. Si no, aborta con un error 403
function authorize($validate)
{
    if (!$validate) {
        abort(403);
    }
    return true;
}

// Verifica si el usuario es administrador consultando la tabla admin
function isAdmin() {
    if (!isset($_SESSION['user'])) {
        return false;
    }
    $db = new \Core\DataBase();
    $usuario = $_SESSION['user'];
    $admin = $db->queryReturnArray(
        'SELECT * FROM admin WHERE usuario = :usuario',
        ['usuario' => $usuario]
    );
    return !empty($admin);
}

function inSession() {
    if (!isset($_SESSION['user'])) {
        return false;
    }
    return true;
}

// Verifica si el usuario es superadmin consultando la tabla admin
function isSuperAdmin() {
    if (!isset($_SESSION['user'])) {
        return false;
    }
    $db = new \Core\DataBase();
    $usuario = $_SESSION['user'];
    $admin = $db->queryReturnArray(
        'SELECT * FROM usuarios WHERE usuario = :usuario',
        ['usuario' => $usuario]
    );
    return !empty($admin) && $admin[0]['nivel_acceso'] == 'superadmin';
}

// Inicia sesión almacenando el email del usuario y su información en la sesión
function logIn($email)
{
    // Obtenemos la información del usuario
    $db = new \Core\DataBase();
    $user = $db->queryReturnArray(
        'SELECT * FROM usuarios WHERE email = :email', 
        ['email' => $email]
    );
    
    if (!empty($user)) {
        // Guardamos la información relevante en la sesión
        $_SESSION['user'] = [
            'id' => $user[0]['id'],
            'email' => $email,
            'nombre' => $user[0]['nombre'],
            'apellido' => $user[0]['apellido'],
            'nivel_acceso' => $user[0]['nivel_acceso'],
            'activo' => $user[0]['activo']
        ];
    }
}

// Send a JSON response
function json_response($data)
{
    header('Content-Type: application/json');
    echo json_encode($data);
    die();
}

// Cierra la sesión del usuario y elimina la cookie de sesión
function logOut()
{
    session_destroy();
    $params = session_get_cookie_params();
    setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
}

// Redirige a una URL específica
function redirect($url)
{
    header("Location: " . Url($url));
    exit();
}

/**
 * Obtiene datos de la petición de forma segura
 * @param string|array $key La clave o array de claves a obtener
 * @param mixed $default Valor por defecto si la clave no existe
 * @return mixed El valor de la clave o array con los valores solicitados
 */
function request($key = null, $default = null)
{
    $method = $_SERVER['REQUEST_METHOD'];
    $input = [];
    
    // Obtener datos según el método de la petición
    switch($method) {
        case 'GET':
            $input = $_GET;
            break;
        case 'POST':
            $input = $_POST;
            // Si es JSON, lo decodificamos
            if (empty($_POST) && !empty(file_get_contents('php://input'))) {
                $json = json_decode(file_get_contents('php://input'), true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $input = $json;
                }
            }
            break;
        case 'PUT':
        case 'DELETE':
            parse_str(file_get_contents('php://input'), $input);
            break;
    }

    // Si no se especificó clave, devolver todos los datos
    if ($key === null) {
        return $input;
    }

    // Si es un array de claves
    if (is_array($key)) {
        $result = [];
        foreach ($key as $k) {
            $result[$k] = $input[$k] ?? $default;
        }
        return $result;
    }

    // Si es una sola clave
    return $input[$key] ?? $default;
}



// Genera un token CSRF y lo almacena en la sesión
function csrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8') . '">';
}



// Valida el token CSRF
function validateCsrfToken() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['csrf_token'])) {
            http_response_code(403);
            die('Token CSRF no encontrado. Por favor, recarga la página e intenta nuevamente.');
            
        }

        if (!isset($_SESSION['csrf_token'])) {
            http_response_code(403);
            die('Sesión CSRF expirada. Por favor, recarga la página e intenta nuevamente.');
            
        }

        if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
            http_response_code(403);
            die('Token CSRF inválido. Posible ataque CSRF detectado.');
        }

        // Regenerar el token después de una validación exitosa para mayor seguridad
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}

