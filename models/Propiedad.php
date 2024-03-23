<?php

namespace Model;

class Propiedad extends ActiveRecord {
    
    protected static $tabla = 'propiedades';
    protected static $columnasDB = [
        'id',
        'titulo',
        'precio',
        'imagen',
        'descripcion',
        'habitaciones',
        'bano',
        'estacionamiento',
        'creado',
        'vendedorID'
    ];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $bano;
    public $estacionamiento;
    public $creado;
    public $vendedorID;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->bano = $args['bano'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorID = $args['vendedorID'] ?? '';
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un titulo";
        }
        if (!$this->precio) {
            self::$errores[] = "Debes añadir un precio";
        }
        if (strlen($this->descripcion) > 200) {
            self::$errores[] = "Debes añadir una descripción de máximo 200 caracteres";
        }
        if (!$this->habitaciones) {
            self::$errores[] = "Debes agg una habitaciones";
        }
        if (!$this->bano) {
            self::$errores[] = "Debes agg un baño";
        }
        if (!$this->estacionamiento) {
            self::$errores[] = "Debes agg un estacionamiento";
        }
        if (!$this->vendedorID) {
            self::$errores[] = "Debes selecionar un vendedor";
        }
        if (!$this->imagen) {
            self::$errores[] = "Debes seleccionar una imagen";
        }

        return self::$errores;
    }
}
