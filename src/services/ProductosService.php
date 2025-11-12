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

        public function findByMarca($marca){
            $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE marca = '$marca' ORDER BY id ASC;");
            $stmt->execute();

            $productos = [];

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
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
                    $row['is_deleted'] 
                );
                $productos[]=$producto;
            }

            $stmt = null;
            return $productos;
        }

        public function findByModelo($modelo){
            $stmt = $this->pdo->prepare("SELECT * FROM productos WHERE modelo = '$modelo' ORDER BY id ASC;");
            $stmt->execute();

            $productos = [];

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
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
                    $row['is_deleted'] 
                );
                $productos[]=$producto;
            }

            $stmt = null;
            return $productos;
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
                    $row['is_deleted'] 
                );

                $stmt = null;
                return $producto;
            }
            return false;
        }

        public function findAllWithCategoryName($nombre_categoria){
            $categoriaService = new CategoriasService($this->pdo);
            $categoria = $categoriaService->findByName($nombre_categoria);
            $id_categoria = $categoria->id;

            $stmt = $this->pdo->prepare("SELECT * FROM productos 
            WHERE categoria_id = $id_categoria ORDER BY id ASC;");
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
                    $row['is_deleted']                    
                );
                $productos[]=$producto;
            }

            $stmt = null;
            return $productos;

        }

        public function findAll(){
            $stmt = $this->pdo->prepare("SELECT * FROM productos ORDER BY id ASC;");
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
            }

            $stmt = null;
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

                
                if($stmt->execute($datos)){
                    //echo "<br>Se han modificado los datos del Producto $modeloAntiguo.<br>";
                }else{
                    echo "<br>Ha habido un error al modificar los datos del Producto $modeloAntiguo.<br>";
                };

                $stmt = null;
            }catch(PDOException $e){
                echo $e->getMessage();
            }
        }
    }
?>