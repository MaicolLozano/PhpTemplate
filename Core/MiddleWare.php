<?php 
namespace Core;

class MiddleWare {
    
    // Verifica si el usuario está autenticado; si no, lo redirige al login
    public function Auth() {
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('location: ' . Url('/login'));
            exit;
        }
        
        // Verificar que la sesión tenga la estructura correcta
        if (!is_array($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            session_destroy();
            header('location: ' . Url('/login'));
            exit;
        }
    }

    // Verifica si el usuario es un invitado (no autenticado); si está autenticado, lo redirige a la página principal
    public function Guest() {
        if ($_SESSION['user'] ?? false) {
            header('location: ' . Url('/'));
            exit;
        }
    }
    
    // Verifica si el usuario tiene rol de administrador (nivel admin o superadmin)
    public function Admin() {
         // Primero verificamos que el usuario esté autenticado
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('location: ' . Url('/login'));
            exit;
        }
        
        // Verificar estructura de sesión
        if (!is_array($_SESSION['user']) || !isset($_SESSION['user']['nivel_acceso'])) {
            session_destroy();
            header('location: ' . Url('/login'));
            exit;
        }
        
        // Verificar si tiene permisos de superadministrador
        if ($_SESSION['user']['nivel_acceso'] !== 'admin') {
            abort(403);
            exit;
        }
    }
    
    // Verifica si el usuario tiene rol de superadministrador
    public function SuperAdmin() {
        // Primero verificamos que el usuario esté autenticado
        if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            header('location: ' . Url('/login'));
            exit;
        }
        
        // Verificar estructura de sesión
        if (!is_array($_SESSION['user']) || !isset($_SESSION['user']['nivel_acceso'])) {
            session_destroy();
            header('location: ' . Url('/login'));
            exit;
        }
        
        // Verificar si tiene permisos de superadministrador
        if ($_SESSION['user']['nivel_acceso'] !== 'superadmin') {
            abort(403);
            exit;
        }
    }
}

