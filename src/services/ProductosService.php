<?php
    namespace services;

    use models\Producto;
    use PDO;
    use PDOException;

    require_once dirname(__FILE__) . "/../models/Producto.php";

    class ProductosService{
        private $pdo;

        public function __construct($pdo)
        {
            $this->pdo = $pdo;
        }

        public function findById($id){
            $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE id = $id ORDER BY id ASC;");
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if($row){
                $producto = Producto::__constructFull(
                    $row['id'],
                    $row['uuid'],
                    $row['descripcion'],
                    $row['imagen'],
                    $row['marca'],
                    $row['modelo'],
                    $row['precio'],
                    $row['stock'],
                    $row['created_at'],
                    $row['updated_at'],
                    $row['categoria_id'],
                    null,
                    $row['is_deleted'] 
                );

                $stmt = null;
                return $producto;
            }
            return null;
        }

        public function findAllWithCategoryName($searchParam){
            $stmt = $this->pdo
                ->prepare("SELECT p.id, p.marca, p.modelo, p.precio, p.imagen, p.stock, p.is_deleted, p.created_at, p.updated_at, 
                    p.uuid, p.descripcion, c.nombre AS categoria_nombre, p.categoria_id 
                    FROM productos p JOIN categorias c 
                    ON p.categoria_id=c.id WHERE p.marca LIKE '%$searchParam%' OR p.modelo LIKE '%$searchParam%' 
                    ORDER BY p.id ASC;");
            $stmt->execute();

            $productos = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $producto = Producto::__constructFull(
                    $row['id'],
                    $row['uuid'],
                    $row['descripcion'],
                    $row['imagen'],
                    $row['marca'],
                    $row['modelo'],
                    $row['precio'],
                    $row['stock'],
                    $row['created_at'],
                    $row['updated_at'],
                    $row['categoria_id'],
                    $row['categoria_nombre'],
                    $row['is_deleted']                    
                );
                $productos[]=$producto;
            }

            $stmt = null;
            return $productos;

        }

        public function save(Producto $producto){

            $stmt = $this->pdo->prepare("INSERT INTO productos(uuid, descripcion, imagen, marca,
                modelo, precio, stock, created_at,
                updated_at, categoria_id, is_deleted) 
                VALUES(:uuid, :descripcion, :imagen, :marca,
                :modelo, :precio, :stock, :created_at,
                :updated_at, :categoria_id, :is_deleted);");

            $datos = array(
                'uuid' => $producto->uuid,
                'descripcion' => $producto->descripcion,
                'imagen' => $producto->imagen,
                'marca' => $producto->marca,
                'modelo' => $producto->modelo,
                'precio' => $producto->precio,
                'stock' => $producto->stock,
                'created_at' => $producto->createdAt,
                'updated_at' => $producto->updatedAt,
                'categoria_id' => $producto->categoriaId,
                'is_deleted' => $producto->isDeleted == true ? "true": "false"
            );

            
            
            if($stmt->execute($datos)){
                //echo "<br>Se han guardado los datos del Producto $producto->modelo.<br>";
            }else{
                echo "<br>Ha habido un error al guardar los datos del Producto $producto->modelo.<br>";
            };

            $stmt = null;
        }

        public function deleteById($idProducto){
            $stmt = $this->pdo->prepare("DELETE FROM productos WHERE id=$idProducto");
            if(!$stmt->execute()){
                echo "<br>El Producto con id $idProducto no se ha podido eliminar.<br>";
                return false;
            }

            $stmt = null;
            return true;
        }

        public function update(Producto $producto){
            $modeloAntiguo = $producto->modelo;
            try{
                $stmt = $this->pdo->prepare("UPDATE productos 
                    SET descripcion = :descripcion, imagen = :imagen, marca = :marca,
                    modelo = :modelo, precio = :precio, stock = :stock,
                    updated_at = :updated_at, categoria_id = :categoria_id, 
                    is_deleted = :is_deleted 
                    WHERE id=:id;");

                $datos = array(
                    'id' => $producto->id,
                    'descripcion' => $producto->descripcion,
                    'imagen' => $producto->imagen,
                    'marca' => $producto->marca,
                    'modelo' => $producto->modelo,
                    'precio' => $producto->precio,
                    'stock' => $producto->stock,
                    'updated_at' => date("Y-m-d H:i:s", time()),
                    'categoria_id' => $producto->categoriaId,
                    'is_deleted' => $producto->isDeleted == true ? "true": "false"
                );

                
                if(!$stmt->execute($datos)){
                    echo "<br>Ha habido un error al modificar los datos del Producto $modeloAntiguo.<br>";
                };

                $stmt = null;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>