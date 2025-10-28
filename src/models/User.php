<?php

    namespace models;
    
    class User{

        private $username;
        private $id;
        private $password;
        private $nombre;
        private $apellidos;
        private $email;
        private $createdAt;
        private $updatedAt;
        private $isDeleted;
        private $roles;

        function __construct($username, $id, $password, $nombre, $apellidos, $email,
            $createdAt, $updatedAt, $isDeleted, $roles){
            $this->username = $username;
            $this->id=$id;
            $this->password=$password;
            $this->nombre = $nombre;
            $this->apellidos=$apellidos;
            $this->email=$email;
            $this->createdAt= $createdAt;
            $this->updatedAt=$updatedAt;
            $this->isDeleted=$isDeleted;
            $this->roles=$roles;
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