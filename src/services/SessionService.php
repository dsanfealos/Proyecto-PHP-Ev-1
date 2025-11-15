<?php
namespace services;

class SessionService
{
    private static ?SessionService $instance = null;
    private $expiresInSeconds = 3600;
  
    private function __construct(){
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->comprobarTiempoSesion();
    }

    public static function getInstance(){
        if (self::$instance === null) {
            self::$instance = new SessionService();
        }
        return self::$instance;
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
        $_SESSION['logged_in'] = true;

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
        if (isset($_SESSION['last_action']) && isset($_SESSION['logged_in'])) {
            $duracion = $now - $_SESSION['last_action'];
            if ($duracion > $this->expiresInSeconds) {
                $this->logout();
                header("Location:index.php");
                echo "Ha finalizado la sesión. Has pasado más de 30 minutos inactivo.<br>";
            }
        }
        $_SESSION['last_action'] = $now;
    }
}