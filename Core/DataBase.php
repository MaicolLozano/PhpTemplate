<?php 
namespace Core;

use PDO;
use PDOException;

class DataBase
{
    public $connect; // Almacena la conexión a la base de datos

    public function __construct()
    {
        try {
            // Carga la configuración de la base de datos
            $config = require basePath('config.php');

            // Construye el DSN (Data Source Name) para la conexión PDO
            $dsn = 'mysql:' . http_build_query($config['dataBase'], ' ', ';');

            // Establece la conexión con la base de datos
            $this->connect = new PDO($dsn, $config['credentials']['userName'], $config['credentials']['password'], [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Configura el modo de obtención de datos como un array asociativo
            ]);
        } catch (PDOException $exc) {
            // Captura y muestra errores de conexión
            echo "Error en la conexión: " . $exc->getMessage();
        }
    }

    /**
     * Ejecuta una consulta SQL y devuelve los resultados en un array.
     */
    public function queryReturnArray($sql, $params = [])
    {
        try {
            $statement = $this->connect->prepare($sql);
            $statement->execute($params);
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exc) {
            // En lugar de var_dump, retorna un array de error para manejo controlado
            return ['error' => true, 'message' => $exc->getMessage(), 'code' => $exc->getCode()];
        }
    }

    /**
     * Ejecuta una consulta SQL y devuelve un booleano según si hay resultados o no.
     */
    public function queryReturnBoolean($sql, $params = []) 
    {
        try {
            $statement = $this->connect->prepare($sql);
            $statement->execute($params);
            $result = $statement->fetchColumn(); // Obtiene el valor de la primera columna
    
            return (bool) $result; // Convierte el resultado a booleano (true si existe, false si no)
        } catch (PDOException $exc) {
            var_dump($exc);
            return false; // En caso de error, devuelve false
        }
    }

    /**
     * Ejecuta una consulta SQL sin devolver resultados (para INSERT, UPDATE, DELETE).
     */
    public function query($sql, $params = [])
    {
        try {
            $statement = $this->connect->prepare($sql);
            return $statement->execute($params);
        } catch (PDOException $exc) {
            var_dump($exc);
            return false;
        }
    }

    /**
     * Guarda un nuevo registro en la base de datos.
     */
    public function save($table, $params)
    {
        foreach ($params as $key => $value) {
            $arrayColumns[] = $key;
        }

        // Construye los nombres de las columnas y los valores parametrizados
        $columns = implode(', ', array_map(fn($item) => "`$item`", $arrayColumns));
        $values = implode(', ', array_map(fn($item) => ":$item", $arrayColumns));
        $sql = "INSERT INTO `$table` ($columns) VALUES ($values);";

        // Ejecuta la consulta
        return $this->queryReturnBoolean($sql, $params);
    }

    /**
     * Edita un registro existente en la base de datos.
     */
    public function update($table, $params, $id)
    {
        // Construye la parte SET de la consulta SQL
        $set = implode(', ', array_map(fn($key) => "`$key`= :$key", array_keys($params)));
        $sql = "UPDATE `$table` SET $set WHERE id = :id;";

        // Agrega el ID a los parámetros
        $params[':id'] = $id;

        return $this->queryReturnBoolean($sql, $params);
    }

    /**
     * Elimina un registro de la base de datos.
     */
    public function delete($table, $id)
    {
        $params = [':id' => $id];
        $sql = "DELETE FROM `$table` WHERE id = :id;";

        return $this->queryReturnBoolean($sql, $params);
    }

    /**
     * Vacía una tabla por completo.
     */
    public function truncate($table)
    {
        $sql = "TRUNCATE TABLE `$table`;";

        return $this->queryReturnBoolean($sql);
    }

    /**
     * Obtiene todos los registros de una tabla.
     */
    public function get($table)
    {
        $sql = "SELECT * FROM `$table`;";

        return $this->queryReturnArray($sql);
    }
    /**
     * Obtiene registros de una tabla con condiciones WHERE.
     */
    public function selectWhere($table, $where)
    {
        $sql = "SELECT * FROM `$table` WHERE $where;";

        return $this->queryReturnArray($sql);
    }
}
