<?php

namespace Controllers;

use Core\DataBase;

class ApiExampleController
// Controlador para la gestión de usuarios, esto es a modo de ejemplo con todos los metodos
{
   public function index()
   {
      $heading = "Panel de Administración";

      // Conexión a la base de datos
      $db = new DataBase();
      $usuarios = $db->get("usuarios");

      views('params/admin.view.php');
   }
   public function create()
   {
      $heading = "Crear Usuario";

      $db = new DataBase();

      $usuarios = $db->selectWhere("usuarios", "id = 4");

      views('params/create.view.php');
   }
   public function save()
   {
      $heading = "Crear Usuario";

      $db = new DataBase();

      $data = request([
         'nombre',
         'apellido',
         'email',
         'password',
         'nivel_acceso',
         'activo'
      ]);

      // Si se necesita procesar algún campo, por ejemplo, hashear la contraseña
      if (!empty($data['password'])) {
         $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
      }

      $usuarios = $db->save('usuarios', $data);

      views('params/create.view.php');
   }

   public function edit()
   {
      $heading = "Editar Usuario";

      $db = new DataBase();

      $usuarios = $db->selectWhere("usuarios", "id = 4");

      views('params/create.view.php');
   }

   public function update()
   {
      $heading = "Editar Usuario";

      $db = new DataBase();

      $usuarios = $db->update("usuarios", [
         'nombre' => $_POST['nombre'],
         'apellido' => $_POST['apellido'],
         'email' => $_POST['email'],
         'password' => $_POST['password'],
         'nivel_acceso' => $_POST['nivel_acceso'],
         'activo' => $_POST['activo']
      ], 4);

      views('params/create.view.php');
   }

   public function usuarios()
   {
      $heading = "Ejemplo";

      $db = new DataBase();

      $usuarios = $db->get("usuarios");

      json_response($usuarios);
      views('params/admin.view.php');
   }

   public function prueba()
   {
      $heading = "Ejemplo";

      validateCsrfToken();

      $db = new DataBase();

      $data = request(
         [
         'email',
         'password'
      ]
      );

      $db->save("usuarios", $data);
      
      json_response($data);
   }
   public function form()
   {
      views('example.view.php');
   }

}

