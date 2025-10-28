<?php

    namespace models;

    use Ramsey\Uuid\Uuid;

    class Categoria {
        private $id;
        private $nombre;
        private $createdAt;
        private $isDeleted;
    
        public function __construct( $id,  $nombre,  $createdAt,  $isDeleted){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->createdAt = $createdAt;
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