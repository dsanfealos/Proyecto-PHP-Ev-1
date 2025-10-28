<?php

    namespace models;

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

        #Falta revisar lo de "constructor flexible"
        public function __construct( $id,  $uuid,  $descripcion,  $imagen,  $marca,  $modelo,  
            $precio,  $stock,  $createdAt,  $updatedAt,  $categoriaId,  $categoriaNombre,  $isDeleted){
                $this->id = $id;
                $this->uuid = $uuid;
                $this->descripcion = $descripcion;
                $this->imagen = $imagen;
                $this->marca = $marca;
                $this->modelo = $modelo;
                $this->precio = $precio;
                $this->stock = $stock;
                $this->createdAt = $createdAt;
                $this->updatedAt = $updatedAt;
                $this->categoriaId = $categoriaId;
                $this->categoriaNombre = $categoriaNombre;
                $this->isDeleted = $isDeleted;
        }

        public function __get($name)
        {
            return $this->$name;
        }

        public function __set($name, $value)
        {
            $this->$name = $value;
        }
    }
?>