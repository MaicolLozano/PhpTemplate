<?php
// index
$router->get('/', "HomeController@index");

// Inicio y cierre de sesión
$router->post('/store', "SessionController@store"); // Formulario de registro (solo para invitados)
$router->get('/register', "SessionController@register"); // Formulario de registro (solo para invitados)
$router->get('/login', "SessionController@create")->only('guest'); // Formulario de inicio de sesión (solo para invitados)
$router->post('/login', "SessionController@save"); // Procesar inicio de sesión (requiere método POST)
$router->post('/logout', "SessionController@destroy"); // Cerrar sesión (requiere método DELETE)

// rutas de ejemplo 
$router->get('/admin', "HomeController@index") ->only('admin');
$router->get('/admin/create', "AdminController@create") ->only('superadmin');
$router->post('/admin/create', "AdminController@save") ->only('admin');
$router->get('/admin/edit', "AdminController@edit") ->only('guest');
$router->patch('/admin/edit', "AdminController@update") ->only('auth');
$router->post('/admin/delete', "AdminController@delete");
