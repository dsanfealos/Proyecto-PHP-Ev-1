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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
            rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
            crossorigin="anonymous">
    </head>
    <body class="m-5 pb-4">
        <content class="m-4">
            <h2 class="text-center pt-4">Lista de Productos</h2>
            <div id="listado" class="mt-5 m-5">
                <!-- TODO: Crear buscador por marca o modelo -->
                <table id="tabla-listado" class="table table-striped-columns table-responsive table-bordered border-light table-hover text-center table-dark">
                    <thead class="table-success">
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
                            $productoService = new ProductosService($config->db);
                            $categoriasService = new CategoriasService($config->db);

                            $productos = $productoService->findAll();
                            foreach($productos as $producto){
                                $categoria = $categoriasService->findById($producto->categoriaId);
                                echo ("
                                    <tr>
                                        <td><img src='$producto->imagen' alt='Imagen de producto'></td>
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

                    //Esto hace que se __set funcione para createdAt y isDeleted.
                    /*error_reporting(E_ALL);
                    ini_set('display_errors', 1);*/
                ?>
            </div>
        </content>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
            crossorigin="anonymous"></script>
    </body>
</html>