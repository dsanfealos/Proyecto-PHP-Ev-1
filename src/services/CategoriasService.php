<?php
    namespace services;

    use models\Categoria;
    use PDO;

    require_once dirname(__FILE__) . "/../models/Categoria.php";

    class CategoriasService {
        private $pdo;

        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        public function findAll(){
            $stmt = $this->pdo->prepare("SELECT * FROM categorias ORDER BY id ASC;");
            $stmt->execute();

            $categorias = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $categoria = new Categoria(
                    $row['id'],
                    $row['nombre'],
                    $row['created_at'],
                    $row['updated_at'],
                    $row['is_deleted']
                );

                #Revisar porque yo ahí no veo un index 
                #para decir en qué parte del array se mete 
                #la nueva categoría.
                $categorias[]=$categoria;
            }

            return $categorias;
        }


        public function findByName($name)
        {
            $stmt = $this->pdo->prepare("SELECT * FROM categorias WHERE nombre = :nombre");
            $stmt->execute(['nombre' => $name]);

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return false;
            }
            $categoria = new Categoria(
                $row['id'],
                $row['nombre'],
                $row['created_at'],
                $row['updated_at'],
                $row['is_deleted']
            );
            return $categoria;
        }
    }
?>