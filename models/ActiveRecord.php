<?php
namespace Model;

class ActiveRecord
{
    // Base de datos
    protected static $db;
    protected $id;
    protected $imagen;
    protected static $tabla = '';
    protected static $columnasDB = [];
    // Errores
    protected static $errores = [];


    // Definir la conexion a la base de datos
    public static function setDB($database)
    {
        self::$db = $database;
    }
    public function guardar()
    {
        if (!is_null($this->id)) {
            $this->actualizar();
        } else {
            $this->crear();
        }
    }
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizaAtributos();

        // INSERTAR EN LA BDD
        $query = "INSERT INTO " . static::$tabla . "  ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$db->query($query);

        if ($resultado) {
            // Redireccionar al user
            header('Location: /admin?resultado=1');
        }
    }

    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizaAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key} = '{$value}'";
        }

        // INSERTAR EN LA BDD
        $query = "UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado) {
            // Redireccionar al user
            header('Location: /admin?resultado=2');
        }
    }

    // Eliminar un registro
    public function eliminar()
    {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $query = "DELETE FROM " . static::$tabla . " WHERE id = " .
                self::$db->escape_string($this->id) . " LIMIT 1";
            $resultado = self::$db->query($query);

            if ($resultado) {
                $this->borrarImagen();
                header('location: /admin?resultado=3');
            }
        } catch (\mysqli_sql_exception $e) {
            if ($e->getCode() == 1451) { // 1451 es el código de error
                // Aquí puedes manejar el error, por ejemplo, redirigir a una página de error o mostrar un mensaje
                echo "<script>alert('No se puede borrar este registro'); window.location.href='/admin';</script>";
            } else {
                throw $e; // Si el error es diferente, lo lanzamos de nuevo
            }
        }
    }

    // Identificar y unir los atributos de la clase
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') {
                continue;
            }
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizaAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Subida de archivos
    public function setImagen($imagen)
    {
        // Eliminar la imagen previa
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }
        // Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    // Eliminar imagen
    public function borrarImagen()
    {
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }

    // Valida los datos
    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    // Listar todas las tablas
    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;

        return self::consultarSQL($query);
    }

    // Obtener determinado numero de registros
    public static function get($cantidad)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $cantidad;
        return self::consultarSQL($query);
    }

    // Buscar una tabla por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // Liberar la memoria
        $resultado->free();

        // Retornar los resultados
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Sincronizar el objeto en memoria con los datos de la BDD
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
