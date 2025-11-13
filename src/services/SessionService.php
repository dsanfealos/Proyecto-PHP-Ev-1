<?php
namespace services;

class SessionService
{
  
    public function __construct(){
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->comprobarTiempoSesion();
    }

    public function login($usuario){

        $roles = [];
        foreach($usuario->roles as $rol){
            $roles[]=$rol;
        }
        $_SESSION['user'] = $usuario->username;
        if (in_array('ADMIN', $roles)){
            $_SESSION['rol'] = 'ADMIN';
        }else{
            $_SESSION['rol'] = $usuario->roles[0];
        }
        $_SESSION['last_action'] = time();

        setcookie("usuario", $_SESSION['user'], time() + 1800, "/");
        setcookie("rol", $_SESSION['rol'], time() + 1800, "/");
    }
 
    public function logout(){
        setcookie("usuario", $_SESSION['user'], time() - 3600, "/");
        setcookie("rol", $_SESSION['rol'], time() - 3600, "/");
        session_destroy();
    }
   
    private function comprobarTiempoSesion(){
        $now = time();
        $tiempoMax = 1800;
        if (isset($_SESSION['last_action'])) {
            $duracion = $now - $_SESSION['last_action'];
            if ($duracion > $tiempoMax) {
                $this->logout();
                header("Location:index.php");
                echo "Ha finalizado la sesión. Has pasado más de 30 minutos inactivo.<br>";
            }
        }
        $_SESSION['last_action'] = $now;
    }
}