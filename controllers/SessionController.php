<?php

namespace Controllers;

use Core\DataBase;

class SessionController
{

    /* 
     * Muestra la vista de login
     */
    public function create()
    {
        $heading = "Iniciar Sesión";

        require views('session/login.view.php');
    }

    /* 
     * Muestra la vista de registro
     */
    public function register()
    {
        $heading = "Registrarse";

        views('session/register.view.php');
    }

    /* 
     * Procesa el login
     */
    public function save()
    {

        // Obtener datos del formulario
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email)) {
            $errors['email'] = 'El email es requerido';
        }

        if (empty($password)) {
            $errors['password'] = 'La contraseña es requerida';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'El formato del email no es válido';
        }

        // Si hay errores, regresar al formulario
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = ['email' => $email];
            redirect('/login');
            exit;
        }

        // Validar CSRF token después de las validaciones básicas
        validateCsrfToken();

        try {
            // Conectar a la base de datos
            $db = new DataBase();

            // Buscar usuario en la base de datos
            $usuario = $db->queryReturnArray(
                'SELECT * FROM usuarios WHERE email = :email AND activo = 1',
                ['email' => $email]
            );

            // Verificar si el usuario existe y la contraseña es correcta
            if (!empty($usuario) && password_verify($password, $usuario[0]['password'])) {
                // Usuario autenticado correctamente
                $userData = $usuario[0];

                // Crear sesión del usuario
                $_SESSION['user'] = [
                    'id' => $userData['id'],
                    'email' => $userData['email'],
                    'nombre' => $userData['nombre'],
                    'apellido' => $userData['apellido'],
                    'nivel_acceso' => $userData['nivel_acceso']
                ];
                error_log("SessionController: User logged in with nivel_acceso = '" . $userData['nivel_acceso'] . "'");

                // Opcional: Registrar sesión en la tabla de sesiones
                $sessionId = session_id();
                $ipAddress = $_SERVER['REMOTE_ADDR'] ?? '';
                $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
                $fechaExpiracion = date('Y-m-d H:i:s', time() + (24 * 60 * 60)); // 24 horas

                $db->query(
                    'INSERT INTO sesiones (id, usuario_id, ip_address, user_agent, fecha_expiracion)
                     VALUES (:session_id, :usuario_id, :ip_address, :user_agent, :fecha_expiracion)
                     ON DUPLICATE KEY UPDATE
                     fecha_inicio = CURRENT_TIMESTAMP,
                     fecha_expiracion = :fecha_expiracion2,
                     activa = 1',
                    [
                        'session_id' => $sessionId,
                        'usuario_id' => $userData['id'],
                        'ip_address' => $ipAddress,
                        'user_agent' => $userAgent,
                        'fecha_expiracion' => $fechaExpiracion,
                        'fecha_expiracion2' => $fechaExpiracion
                    ]
                );

                // Limpiar errores de sesión
                unset($_SESSION['errors']);
                unset($_SESSION['old']);

                // Redirigir según el nivel de acceso
                if ($userData['nivel_acceso'] === 'admin' || $userData['nivel_acceso'] === 'superadmin') {
                    // Verificar/crear entrada en tabla admin para compatibilidad
                    $adminExists = $db->queryReturnArray(
                        'SELECT * FROM admin WHERE usuario = :usuario',
                        ['usuario' => $email]
                    );

                    if (empty($adminExists)) {
                        $nivel = ($userData['nivel_acceso'] === 'superadmin') ? 2 : 1;
                        $db->query(
                            'INSERT INTO admin (usuario, nivel) VALUES (:usuario, :nivel)',
                            ['usuario' => $email, 'nivel' => $nivel]
                        );
                    }

                    redirect('/');
                } else {
                    redirect('/');
                }
                exit;

            } else {
                // Credenciales incorrectas
                $_SESSION['errors'] = ['login' => 'Email o contraseña incorrectos'];
                $_SESSION['old'] = ['email' => $email];
                redirect('/login');
                exit;
            }

        } catch (Exception $e) {
            // Error en la base de datos
            $_SESSION['errors'] = ['login' => 'Error del sistema. Intente nuevamente.'];
            $_SESSION['old'] = ['email' => $email];
            redirect('/login');
            exit;
        }
    }

    /* 
     * Procesa el registro
     */
    public function store()
    {
        // Validar CSRF token primero
        validateCsrfToken();

        // obtener los datos del formulario
        $data = [
            'nombre' => $_POST['nombre'],
            'apellido' => $_POST['apellido'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];

        // validar los datos
        if (empty($data['nombre']) || empty($data['apellido']) || empty($data['email']) || empty($data['password'])) {
            redirect('/register');
            exit;
        }

        // encriptar la contraseña
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // insertar los datos en la base de datos
        $db = new DataBase();
        $db->query(
            'INSERT INTO usuarios (nombre, apellido, email, password) VALUES (:nombre, :apellido, :email, :password)',
            $data
        );

        // redirigir a la pagina de login
        redirect('/login');
        exit;
    }

    /* 
     * Procesa el logout
     */
    public function destroy()
    {
        // Marcar sesión como inactiva en la base de datos si existe
        if (isset($_SESSION['user']) && is_array($_SESSION['user']) && isset($_SESSION['user']['id'])) {
            try {
                $db = new DataBase();
                $sessionId = session_id();

                // Marcar sesión como inactiva
                $db->query(
                    'UPDATE sesiones SET activa = 0 WHERE id = :session_id',
                    ['session_id' => $sessionId]
                );
            } catch (Exception $e) {
                // Si hay error en la base de datos, continuar con el logout
                error_log('Error al actualizar sesión: ' . $e->getMessage());
            }
        }

        // Limpiar todas las variables de sesión
        $_SESSION = [];

        // Destruir la sesión
        session_destroy();

        // Redirigir al login
        redirect('/login');
        exit;
    }
}