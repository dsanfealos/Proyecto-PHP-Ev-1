<?php
    include_once dirname(__FILE__) . "/../src/header.php";
    include_once dirname(__FILE__) . "/../src/footer.php";
    include_once dirname(__FILE__) . "/../src/services/CategoriasService.php";
    include_once dirname(__FILE__) . "/../src/config/Config.php";

    use services\CategoriasService;
    use config\Config;
    use models\Producto;
    use services\ProductosService;

?>

<html>    
    <head>
        <title>Prueba</title>
        <link href="estilos.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <content>

            <div id="listado">
                <table id="tabla-listado">
                    <thead>
                        <tr>
                            <th>Imagen</th>
                            <th>Id</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $config = Config::getInstance();
                            //Leer Todos
                            $productoService = new ProductosService($config->db);
                            $categoriasService = new CategoriasService($config->db);

                            $productos = $productoService->findAll();
                            foreach($productos as $producto){
                                $categoria = $categoriasService->findById($producto->categoriaId);
                                echo ("
                                    <tr>
                                        <td>$producto->imagen</td>
                                        <td>$producto->id</td>
                                        <td>$producto->marca</td>
                                        <td>$producto->modelo</td>
                                        <td>$categoria->nombre</td>
                                        <td>$producto->stock ud.</td>
                                        <td>$producto->descripcion</td>
                                        <td>$producto->precio €</td>
                                        <td><div>
                                            <form action='update.php' method='post'>
                                                <input name='id' value='$producto->id' style='display:none;'>
                                                <input type='submit' value='Modificar'>
                                            </form>
                                            <form action='delete.php' method='post'>
                                                <input name='id' value='$producto->id' style='display:none;'>
                                                <input type='submit' value='Eliminar'>
                                            </form>
                                        </div></td>
                                    </tr>
                                ");
                            }
                        ?>
                    </tbody>
                    
                </table>
            </div>
            
            
            <div id="contenido-test">
                <?php
                    echo "Buenas tardes.<br>";
                    echo "Categorías: <br>";


                    $categorias = $categoriasService->findAll();
                    $count = 1;
                    foreach($categorias as $categoria){
                        echo $count . " ";
                        $count++;
                        print_r($categoria->nombre);
                        echo "<br>";
                    }

                    //Leer Todos
                    echo "<br>Sección de Productos<br>";
                    $productoService = new ProductosService($config->db);
                    $productos = $productoService->findAll();
                    $count = 1;
                    foreach($productos as $producto){
                        echo $count . " ";
                        $count++;
                        print_r($producto->modelo);
                        echo "<br>";
                    }

                    //Leer todos con categoría deportes
                    echo "<br>Sección de Productos con categoría Deportes<br>";
                    $productoService = new ProductosService($config->db);
                    $productos = $productoService->findAllWithCategoryName('DEPORTES');
                    $count = 1;
                    foreach($productos as $producto){
                        echo $count . " ";
                        $count++;
                        print_r($producto->modelo);
                        echo "<br>";
                    }    

                    //Leer 1
                    echo "<br>Encontrar un solo Producto.<br>";
                    $productoSeparado = $productoService->findByModelo("Calcetines Mickey")[0];
                    echo "id:" . $productoSeparado->id . " | ";
                    echo "uuid:" . $productoSeparado->uuid . " | ";
                    echo "descripcion:" . $productoSeparado->descripcion . "<br>";
                    echo "imagen:" . $productoSeparado->imagen . " | ";
                    echo "marca:" . $productoSeparado->marca . " | ";
                    echo "modelo:" . $productoSeparado->modelo . "<br>";
                    echo "precio:" . $productoSeparado->precio . " | ";
                    echo "stock:" . $productoSeparado->stock . " | ";
                    echo "createdAt:" . $productoSeparado->createdAt . "<br>";
                    echo "updatedAt:" . $productoSeparado->updatedAt . " | ";
                    echo "categoriaId:" . $productoSeparado->categoriaId . " | ";
                    echo "isDeleted:" . $productoSeparado->isDeleted . "<br>";
                    


                    //Esto hace que se __set funcione para createdAt y isDeleted.
                    /*error_reporting(E_ALL);
                    ini_set('display_errors', 1);*/


                    //crear
                    /*$productoACrear = new Producto('Rolex', 'Mc and Morcilla', 521.95, 2, 'COMIDA');
                    $productoCreado = $productoService->create($productoACrear);*/

                    //borrar
                    /*echo "Vamos a borrar el producto con id 7.<br>";
                    $productoService->deleteById(6);*/

                    //Update
                    /*echo "Vamos a modificar el producto con id 8 para tener otro modelo.<br>";
                    $productoAModificar = $productoService->findByModelo('Mc and Morcilla');
                    $productoAModificar->modelo = 'Burguesa de Queso';
                    $productoService->update($productoAModificar);*/
                ?>
                <button type="button">Click Me!</button>
            </div>
        </content>
    </body>
</html>