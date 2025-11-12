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
        <title>Home</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <!--<link href="estilos.css" type="text/css" rel="stylesheet">-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
            rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
            crossorigin="anonymous">
    </head>
    <body class="m-5 pb-4">
        <content class="m-4">
            <h2 class="text-center pt-4">Lista de Productos</h2>
            <div id="listado" class="mt-5 m-5">
                <table id="tabla-listado" class="table table-striped-columns table-responsive table-bordered border-light table-hover text-center table-dark">
                    <thead class="table-danger">
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
                                            <form action='details.php' method='GET' class='d-inline'>
                                                <input name='id' value='$producto->id' style='display:none;'>
                                                <input type='submit' class='btn btn-info' value='Detalles'>
                                            </form>
                                            <form action='update-image.php' method='GET' class='d-inline'>
                                                <input name='id' value='$producto->id' style='display:none;'>
                                                <input type='submit' class='btn btn-secondary' value='Cambiar Imagen'>
                                            </form>
                                            <form action='update.php' method='GET' class='d-inline'>
                                                <input name='id' value='$producto->id' style='display:none;'>
                                                <input type='submit' class='btn btn-primary' value='Modificar'>
                                            </form>
                                            <form action='delete.php' method='GET' class='d-inline'>
                                                <input name='id' value='$producto->id' style='display:none;'>
                                                <input type='submit' class='btn btn-danger' value='Eliminar'>
                                            </form>
                                        </div></td>
                                    </tr>
                                ");
                            }
                        ?>
                    </tbody>
                    
                </table>
                <button class="btn btn-success"><a href="create.php" class="text-white text-decoration-none">Crear Producto</a></button>
            </div>
            
            
            <div id="contenido-test">
                <?php
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

                    //Esto hace que se __set funcione para createdAt y isDeleted.
                    /*error_reporting(E_ALL);
                    ini_set('display_errors', 1);*/

                    //Update
                    /*echo "Vamos a modificar el producto con id 8 para tener otro modelo.<br>";
                    $productoAModificar = $productoService->findByModelo('Mc and Morcilla');
                    $productoAModificar->modelo = 'Burguesa de Queso';
                    $productoService->update($productoAModificar);*/
                ?>
                <button type="button">Click Me!</button>
            </div>
        </content>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
            crossorigin="anonymous"></script>
    </body>
</html>