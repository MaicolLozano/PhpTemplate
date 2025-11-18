# Sistema MVC

## Descripción General

Este es un sistema web PHP desarrollado con arquitectura MVC personalizada. Cuenta con caracteristicas como autenticacion, control de acceso, enrutamiento, base de datos, controladores, vistas y configuración.

## Tabla de Contenidos

1. [Arquitectura del Sistema](#arquitectura-del-sistema)
2. [Estructura de Directorios](#estructura-de-directorios)
3. [Sistema Core](#sistema-core)
4. [Sistema de Autenticación](#sistema-de-autenticación)
5. [Sistema de Rutas](#sistema-de-rutas)
6. [Base de Datos](#base-de-datos)
7. [Controladores](#controladores)
8. [Vistas](#vistas)
9. [Configuración](#configuración)
10. [Instalación](#instalación)
11. [Uso del Sistema](#uso-del-sistema)

---

## Arquitectura del Sistema

El sistema sigue una arquitectura **MVC (Modelo-Vista-Controlador)** personalizada con los siguientes componentes principales:

- **Core**: Clases fundamentales del sistema (Router, Database, Middleware, Functions)
- **Controllers**: Lógica de negocio y manejo de peticiones
- **Views**: Presentación e interfaz de usuario
- **Models**: Representados por la clase Database para interacción con datos

### Flujo de Ejecución

1. **Entrada**: Todas las peticiones pasan por `public/index.php`
2. **Enrutamiento**: El Router analiza la URL y determina el controlador
3. **Middleware**: Se ejecutan verificaciones de autenticación/autorización
4. **Controlador**: Se ejecuta la lógica de negocio correspondiente
5. **Vista**: Se renderiza la respuesta al usuario

---

## Estructura de Directorios

```
c:\wamp64\www\
├── Core/                    # Clases fundamentales del sistema
│   ├── DataBase.php        # Manejo de base de datos
│   ├── MiddleWare.php      # Control de acceso y autenticación
│   ├── Router.php          # Sistema de enrutamiento
│   └── functions.php       # Funciones auxiliares
├── controllers/            # Controladores del sistema
│   ├── adminController.php             # Gestión de administradores
│   ├── dataController.php              # Gestión de datos CSV
│   ├── paramsController.php            # Gestión de parámetros/eventos
│   └── sessionController.php           # Autenticación y sesiones
├── views/                 # Vistas y templates
│   ├── admin/            # Vistas de administración
│   ├── data/             # Vistas de datos
│   ├── includes/         # Componentes reutilizables
│   ├── params/           # Vistas de parámetros
│   └── session/          # Vistas de autenticación
├── public/               # Archivos públicos
│   ├── css/             # Hojas de estilo
│   ├── js/              # Scripts JavaScript
│   ├── img/             # Imágenes
│   └── .htaccess        # Configuración Apache
├── storage/              # Almacenamiento de logs y cache
├── sql/                 # Scripts de base de datos
│   └── database.sql     # Estructura y datos iniciales
├── .htaccess           # Redirección a public/
└── routes.php          # Definición de rutas
```

---

## Sistema Core

### 1. DataBase.php

**Propósito**: Manejo de conexiones y operaciones de base de datos usando PDO.

**Características principales**:
- Conexión segura con PDO
- Prepared statements para prevenir SQL injection
- Métodos CRUD simplificados
- Manejo de errores robusto

**Métodos principales**:

```php
// Conexión automática en el constructor
public function __construct()

// Ejecutar consultas que retorna varios registros
public function queryReturnArray($sql, $params = [])

// Ejecutar consultas que retornan boolean
public function queryReturnBoolean($sql, $params = [])

// Ejecutar consultas sin retorno (INSERT, UPDATE, DELETE)
public function query($sql, $params = [])

// Operaciones CRUD simplificadas
public function save($table, $params)      // INSERT
public function edit($table, $params, $id) // UPDATE
public function delete($table, $id)        // DELETE
public function get($table)                // SELECT ALL

// Utilidades
public function getFormatJson($array)      // Respuesta JSON
public function truncate($table)           // Vaciar tabla
```

**Ejemplo de uso**:
```php
$db = new DataBase();

// Consulta con parámetros
$usuarios = $db->queryReturnArray(
    'SELECT * FROM usuarios WHERE activo = :activo', 
    ['activo' => 1]
);

// Insertar nuevo registro
$db->save('usuarios', [
    'email' => 'usuario@email.com',
    'password' => password_hash('password', PASSWORD_DEFAULT),
    'nombre' => 'Juan',
    'apellido' => 'Pérez'
]);
```

### 2. Router.php

**Propósito**: Sistema de enrutamiento que mapea URLs a controladores.

**Características**:
- Soporte para múltiples métodos HTTP (GET, POST, PUT, PATCH, DELETE)
- Sistema de middleware integrado
- Manejo de errores 404
- Encadenamiento de métodos

**Métodos principales**:
```php
// Definir rutas por método HTTP
public function get($uri, $controller)
public function post($uri, $controller)
public function put($uri, $controller)
public function patch($uri, $controller)
public function delete($uri, $controller)

// Asignar middleware a ruta
public function only($middleware)

// Procesar petición
public function route($uri, $method)
```

**Ejemplo de uso**:
```php
// Ruta simple
$router->get('/usuarios', 'AdminController@index');

// Ruta con middleware
$router->get('/admin', 'AdminController@index')->only('admin');

// Ruta POST
$router->post('/login', 'AdminController@login');
```

### 3. MiddleWare.php

**Propósito**: Control de acceso y verificación de permisos.

**Middlewares disponibles**:

#### `Auth()`
- **Función**: Verifica que el usuario esté autenticado
- **Comportamiento**: Redirige a `/login` si no hay sesión activa
- **Uso**: Rutas que requieren usuario logueado

#### `Guest()`
- **Función**: Verifica que el usuario NO esté autenticado
- **Comportamiento**: Redirige a `/` si ya está logueado
- **Uso**: Páginas de login/registro

#### `Admin()`
- **Función**: Verifica permisos de administrador
- **Comportamiento**: Permite acceso a usuarios `admin` y `superadmin`
- **Uso**: Paneles de administración

#### `SuperAdmin()`
- **Función**: Verifica permisos de superadministrador
- **Comportamiento**: Solo permite acceso a usuarios `superadmin`
- **Uso**: Funciones críticas del sistema

**Ejemplo de verificación**:
```php
// En el middleware Admin()
$nivelAcceso = $_SESSION['user']['nivel_acceso'];
if ($nivelAcceso !== 'admin' && $nivelAcceso !== 'superadmin') {
    header('location: ' . Url('/'));
    exit;
}
```

### 4. functions.php

**Propósito**: Funciones auxiliares globales del sistema.

**Funciones principales**:

```php
// Navegación y URLs
urlIs($url)           // Verifica si la URL actual coincide
Url($url)            // Genera URL absoluta
basePath($path)      // Ruta absoluta del sistema
views($path)         // Ruta a archivos de vista

// Debugging
dd($value)           // Debug y detener ejecución

// Autorización
authorize($validate) // Verifica condición o aborta con 403
abort($code)         // Envía código HTTP y muestra error

// Sesiones (funciones legacy)
logIn($email)        // Iniciar sesión (versión antigua)
logOut()            // Cerrar sesión
inSession()         // Verificar si hay sesión activa
isAdmin()           // Verificar si es administrador

// Utilidades
redirect($url)       // Redireccionar
```

---

## Sistema de Autenticación

### Estructura de Datos de Usuario

El sistema maneja la información del usuario en `$_SESSION['user']` con la siguiente estructura:

```php
$_SESSION['user'] = [
    'id' => 1,
    'email' => 'usuario@email.com',
    'nombre' => 'Juan',
    'apellido' => 'Pérez',
    'nivel_acceso' => 'admin' // 'usuario', 'admin', 'superadmin'
];
```

### Niveles de Acceso

1. **`usuario`**: Acceso básico al sistema
2. **`admin`**: Acceso a paneles de administración
3. **`superadmin`**: Acceso completo al sistema

### Flujo de Autenticación

1. **Login**: Usuario envía credenciales a `/login` (POST)
2. **Validación**: `controllers/session/save.php` verifica en base de datos
3. **Sesión**: Se crea sesión con datos del usuario
4. **Redirección**: Según nivel de acceso (admin → `/admin`, usuario → `/`)

### Controlador de Login (`controllers/sessionController.php`)

**Proceso**:
1. Validación de datos de entrada
2. Búsqueda del usuario en base de datos
3. Verificación de contraseña con `password_verify()`
4. Creación de sesión estructurada
5. Registro en tabla de sesiones
6. Redirección según nivel de acceso

**Características de seguridad**:
- Prepared statements contra SQL injection
- Hash de contraseñas con bcrypt
- Validación de entrada
- Manejo de errores controlado
- Registro de sesiones activas

---

## Sistema de Rutas

### Configuración de Rutas (`routes.php`)

Las rutas se definen usando el patrón:
```php
$router->método('/ruta', "controlador@acción")->only('middleware');
```

### Categorías de Rutas

#### 1. Rutas Públicas
```php
$router->get('/tabla', "tabla@index");
```

#### 2. Rutas Autenticadas (`auth`)
```php
$router->get('/', "index@index")->only('auth');
$router->get('/app', "data@index")->only('auth');
```

#### 3. Rutas de Administrador (`admin`)
```php
$router->get('/params/admin', "params@admin")->only('admin');
$router->get('/usabilidad', "usabilidad@index")->only('admin');
```

#### 4. Rutas de SuperAdministrador (`superadmin`)
```php
$router->get('/admin', "admin@index")->only('superadmin');
$router->get('/admin/create', "admin@create")->only('superadmin');
```

#### 5. Rutas de Invitado (`guest`)
```php
$router->get('/login', "session@create")->only('guest');
```

### Mapeo Middleware-Método

| Middleware | Método en MiddleWare | Descripción |
|------------|---------------------|-------------|
| `auth` | `Auth()` | Usuario autenticado |
| `guest` | `Guest()` | Usuario no autenticado |
| `admin` | `Admin()` | Admin o SuperAdmin |
| `superadmin` | `SuperAdmin()` | Solo SuperAdmin |

---

## Base de Datos

### Estructura de Tablas

#### 1. Tabla `usuarios`
**Propósito**: Almacena información de usuarios del sistema.

```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    nivel_acceso ENUM('usuario', 'admin', 'superadmin') DEFAULT 'usuario',
    activo TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Campos importantes**:
- `email`: Identificador único para login
- `password`: Hash bcrypt de la contraseña
- `nivel_acceso`: Define permisos del usuario
- `activo`: Permite deshabilitar usuarios sin eliminarlos

#### 2. Tabla `admin`
**Propósito**: Compatibilidad con sistema legacy de administradores.

```sql
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(255) NOT NULL UNIQUE,
    nivel TINYINT(1) DEFAULT 1,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario) REFERENCES usuarios(email) ON DELETE CASCADE
);
```

**Relación**: Se sincroniza automáticamente con la tabla `usuarios`.

#### 3. Tabla `sesiones`
**Propósito**: Gestión avanzada de sesiones activas.

```sql
CREATE TABLE sesiones (
    id VARCHAR(128) PRIMARY KEY,
    usuario_id INT NOT NULL,
    ip_address VARCHAR(45),
    user_agent TEXT,
    fecha_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_expiracion TIMESTAMP,
    activa TINYINT(1) DEFAULT 1,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);
```

**Características**:
- Seguimiento de sesiones activas
- Información de seguridad (IP, User Agent)
- Control de expiración
- Limpieza automática en logout

### Usuario por Defecto

**Credenciales**:
- Email: `admin@admin.com`
- Contraseña: `password`
- Nivel: `superadmin`

---

## Controladores

### Estructura de Controladores

#### 1. Controladores de Sesión (`controllers/session/`)

##### `create.php`
- **Propósito**: Mostrar formulario de login
- **Middleware**: `guest`
- **Función**: Cargar vista de login

##### `save.php`
- **Propósito**: Procesar login
- **Método**: POST
- **Proceso**:
  1. Validar datos de entrada
  2. Buscar usuario en BD
  3. Verificar contraseña
  4. Crear sesión
  5. Redirigir según rol

##### `destroy.php`
- **Propósito**: Cerrar sesión
- **Proceso**:
  1. Marcar sesión como inactiva en BD
  2. Destruir sesión PHP
  3. Redirigir a login

#### 2. Controladores de Admin (`controllers/admin`)
- **Acceso**: Solo `superadmin`
- **Funciones**: CRUD de administradores del sistema

#### 3. Controladores de Parámetros (`controllers/params`)
- **Acceso**: `admin` y `superadmin`
- **Funciones**: Gestión de eventos/parámetros

#### 4. Controladores de Datos (`controllers/data`)
- **Funciones**: Gestión de datos CSV, upload, edición

---

## Vistas

### Estructura de Vistas

#### 1. Componentes Reutilizables (`views/includes/`)
- `head.php`: Meta tags, CSS, scripts
- `footer.php`: Pie de página
- `buttons.php`: Botones comunes

#### 2. Vistas de Autenticación (`views/session/`)
- `create.view.php`: Formulario de login

#### 3. Vistas de Administración (`views/admin/`)
- Formularios y listados de administradores

#### 4. Vistas de Datos (`views/data/`)
- Interfaces para gestión de datos CSV

---

## Configuración

### Archivo de Configuración (`config.php`)

```php
return [
    'dataBase' => [
        'host' => 'localhost',
        'port' => 3306,
        'dbname' => 'template_v2',
        'charset' => 'utf8mb4'
    ],
    'credentials' => [
        'userName' => 'root',
        'password' => ''
    ]
];
```

### Variables de Entorno

Definidas en `public/index.php`:
- `BASE_PATH`: Ruta absoluta del proyecto
- `BASE_URL`: URL base de la aplicación

---

## Instalación

### Requisitos

- **PHP**: 7.4 o superior
- **MySQL**: 5.7 o superior
- **Apache**: Con mod_rewrite habilitado
- **WAMP/XAMPP**: Para desarrollo local

### Pasos de Instalación

1. **Clonar/Copiar** el proyecto a la carpeta del servidor web

2. **Configurar Base de Datos**:
   ```bash
   # Importar estructura
   mysql -u root -p < sql/database.sql
   ```

3. **Configurar Apache**:
   - Verificar que `.htaccess` esté habilitado
   - El archivo `.htaccess` raíz redirige todo a `public/`

4. **Configurar PHP**:
   ```php
   // Ajustar config.php según tu entorno
   'credentials' => [
       'userName' => 'tu_usuario',
       'password' => 'tu_contraseña'
   ]
   ```

5. **Verificar Permisos**:
   - Carpeta del proyecto debe ser accesible por Apache
   - PHP debe poder escribir sesiones

### Estructura de URLs

```
http://localhost/proyecto/        → Página principal
http://localhost/proyecto/login   → Formulario de login
http://localhost/proyecto/admin   → Panel de administración
```

---

## Uso del Sistema

### Para Usuarios Regulares

1. **Acceso**: Ingresar con credenciales válidas
2. **Navegación**: Acceso a secciones según permisos
3. **Funciones**: Visualización y gestión de datos permitidos

### Para Administradores

1. **Acceso Adicional**: Paneles de administración
2. **Gestión de Parámetros**: Crear/editar eventos
3. **Monitoreo**: Acceso a datos de usabilidad

### Para SuperAdministradores

1. **Acceso Completo**: Todas las funciones del sistema
2. **Gestión de Usuarios**: Crear/editar administradores
3. **Configuración**: Acceso a configuraciones críticas

### Flujo de Trabajo Típico

1. **Login**: Acceder con credenciales
2. **Dashboard**: Ver información según rol
3. **Navegación**: Usar menús según permisos
4. **Operaciones**: Realizar tareas permitidas
5. **Logout**: Cerrar sesión segura

---

## Seguridad

### Medidas Implementadas

1. **Autenticación**:
   - Hash bcrypt para contraseñas
   - Verificación segura con `password_verify()`

2. **Autorización**:
   - Middleware en cada ruta
   - Verificación de niveles de acceso

3. **Base de Datos**:
   - Prepared statements
   - Validación de entrada

4. **Sesiones**:
   - Seguimiento de sesiones activas
   - Limpieza automática en logout

5. **Estructura**:
   - Archivos críticos fuera de `public/`
   - `.htaccess` para control de acceso

---

## Mantenimiento

### Logs y Debugging

- Usar `dd($variable)` para debugging
- Errores de BD se capturan y manejan
- Logs de sesiones en tabla `sesiones`

### Respaldos

- Respaldar base de datos regularmente
- Mantener copias de archivos de configuración

### Actualizaciones

- Probar cambios en entorno de desarrollo
- Verificar compatibilidad de PHP/MySQL
- Actualizar dependencias si es necesario

---

## Troubleshooting

### Problemas Comunes

1. **Error 500**: Verificar permisos y configuración PHP
2. **No carga CSS/JS**: Verificar rutas en `.htaccess`
3. **Error de BD**: Verificar credenciales en `config.php`
4. **Sesiones no funcionan**: Verificar configuración de sesiones PHP

### Contacto y Soporte

Para soporte técnico o consultas sobre el sistema, contactar al equipo de desarrollo.

---
