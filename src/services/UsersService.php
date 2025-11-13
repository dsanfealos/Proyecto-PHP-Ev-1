<?php

    namespace services;

    use models\User;
    use PDO;
    use PDOException;

    require_once dirname(__FILE__) . "/../models/User.php";

    class UsersService{
        private $pdo;

        public function __construct($pdo){
            $this->pdo = $pdo;
        }

        public function authenticate($username, $password){
            try{
                $usuario = $this->findUserByUserName($username);
                if(!$usuario){
                    echo("<p class='bg-danger p-3 rounded text-white'>¡El usuario no existe!</p><br>");
                    return null;
                }
                $passwordDB = $usuario->password;

                if (password_verify($password, $passwordDB)){
                    return $usuario;
                }
            }catch(Exception $error){
                echo("Error en login: " . $error->getMessage());
            }
            echo("<p class='bg-danger p-3 rounded text-white'>¡La contraseña es incorrecta!</p><br>");
            return null;
        }

        public function findUserByUserName($username){
            $stmt = $this->pdo
                ->prepare("SELECT * FROM usuarios WHERE username = :username");
            $stmt->execute(['username' => $username]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return false;
            }
            $usuario = new User(
                $row['username'],
                $row['id'],
                $row['password'],
                $row['nombre'],
                $row['apellidos'],
                $row['email'],
                $row['created_at'],
                $row['updated_at'],
                $row['is_deleted'],
                null
            );

            $stmt = $this->pdo
                ->prepare("SELECT * FROM user_roles WHERE user_id = :user_id");
            $stmt->execute(['user_id' => $usuario->id]);
            $roles = [];
            while($rowSecondary = $stmt->fetch(PDO::FETCH_ASSOC)){
                $roles[] = $rowSecondary['roles'];
            }
            $usuario->roles = $roles;
            $stmt = null;

            return $usuario;

        }
    }
?>