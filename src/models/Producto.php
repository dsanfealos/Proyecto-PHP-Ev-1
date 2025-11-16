<?php

    namespace models;

    use Ramsey\Uuid\Uuid;

    class Producto {
        private $id;
        private $uuid;
        private $descripcion;
        private $imagen;
        private $marca;
        private $modelo;
        private $precio;
        private $stock;
        private $createdAt;
        private $updatedAt;
        private $categoriaId;
        private $categoriaNombre;
        private $isDeleted;

        public function __construct($marca, $modelo, $precio, $categoriaId, $descripcion, $imagen, $stock){
            $this->marca = $marca;
            $this->modelo = $modelo;
            $this->precio = $precio;
            $this->categoriaId = $categoriaId;
            $this->descripcion = $descripcion;
            $this->imagen = $imagen;
            $this->stock = $stock;
            
            $this->createdAt = date("Y-m-d H:i:s", time());
            $this->isDeleted = false;
            $this->uuid = $this->generateUUID();
        }

        #"constructor flexible"
        public static function __constructFull($id, $uuid, $descripcion,  $imagen,  $marca,  $modelo,  
            $precio,  $stock, $createdAt, $updatedAt,  $categoriaId,  $categoriaNombre, $isDeleted){

                $instance = new self($marca, $modelo, $precio, $categoriaId, $descripcion, $imagen, $stock);
                
                $instance->id = $id;
                $instance->uuid = $uuid;
                $instance->updatedAt = $updatedAt;
                $instance->isDeleted = $isDeleted;
                $instance->createdAt = $createdAt;
                $instance->categoriaNombre = $categoriaNombre;
            return $instance;
        }

        public function __get($name)
            {
                return $this->$name;
            }

        public function __set($name, $value)
        {
            $this->$name = $value;
        }

        public function generateUUID(){
            return Uuid::uuid4()->toString();
        }
    }
?>