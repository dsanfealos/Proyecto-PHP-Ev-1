<?php

    namespace models;

    use Ramsey\Uuid\Uuid;

    class Categoria {
        private $id;
        private $uuid;
        private $nombre;
        private $createdAt;
        private $updatedAt;
        private $isDeleted;
    
        public function __construct( $id,  $uuid, $nombre,  $createdAt,  $updatedAt, $isDeleted){
        $this->id = $id;
        $this->uuid = $uuid;
        $this->nombre = $nombre;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
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
        
        private function generateUUID()
        {
            return Uuid::uuid4()->toString();
        }

    }
?>