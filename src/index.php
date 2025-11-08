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
            
            <button type="button">Click Me!</button>
            <div id="contenido-test">
                <?php
                echo "Buenas tardes.<br>";
                echo "Categorías: <br>";
                $config = Config::getInstance();

                $categoriasService = new CategoriasService($config->db);

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

            
            </div>
            <div id="listado">
                <table id="tabla-listado">
                <tr>
                    <td>Id</td>
                    <td>Marca</td>
                    <td>Modelo</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Adidas</td>
                    <td>Zapatillas N21</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Nike</td>
                    <td>Camiseta X4</td>
                </tr>
            </table>
            </div>
        </content>
    </body>
</html>