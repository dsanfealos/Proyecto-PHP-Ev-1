<?php
    include_once dirname(__FILE__) . "/../src/services/SessionService.php";
    include_once dirname(__FILE__) . "/../src/header.php";
    include_once dirname(__FILE__) . "/../src/footer.php";
    include_once dirname(__FILE__) . "/../src/config/Config.php";

    use config\Config;
    use models\Producto;
    use services\ProductosService;
    use services\SessionService;
    
    $sessionService = SessionService::getInstance();

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
            <h2 class="text-center pt-4 mb-4">Lista de Productos</h2>

            <?php
                if($usuario != 'Invitado'){
                    $nombreUser = $_SESSION['nombre'];
                    $apellidoUser = $_SESSION['apellido'];
                    echo "<h3  class='text-center pt-3 mb-3'>¡Bienvenid@, $nombreUser $apellidoUser!</h3>";

                }

                if(isset($_GET['permission'])){
                    $permiso = $_GET['permission'];

                    if($permiso == false){
                        echo ("<p class='bg-danger p-3 m-5 rounded text-white'>No tienes permisos para realizar esa acción. Necesitas haber iniciado sesión como Administrador.</p><br>");
                    }
                }

                if(isset($_GET['error'])){
                    $error = $_GET['error'];

                    switch($error){
                        case "update":
                            echo ("<p class='bg-danger p-3 mx-5 mt-2 rounded text-white'>Producto a modificar no encontrado</p><br>");
                            break;
                        case "delete":
                            echo ("<p class='bg-danger p-3 mx-5 mt-2 rounded text-white'>El producto a eliminar no ha sido encontrado.</p><br>");
                            break;
                        case "imagen-form":
                            echo ("<p class='bg-danger p-3 mx-5 mt-2 rounded text-white'>La imagen a modificar no ha sido encontrada.</p><br>");
                            break;
                        case "imagen-upload":
                            echo ("<p class='bg-danger p-3 mx-5 mt-2 rounded text-white'>La imagen no ha podido subirse correctamente.</p><br>");
                            break;
                        default:
                            break;
                    }
                }

                if(isset($_GET['exito'])){
                    $exito = $_GET['exito'];

                    switch($exito){
                        case "delete":
                            echo ("<p class='bg-success p-3 mx-5 mt-2 rounded text-white'>El producto eliminado correctamente</p><br>");
                            break;
                        case "imagen-upload":
                            echo ("<p class='bg-success p-3 mx-5 mt-2 rounded text-white'>La imagen ha sido modificada correctamente.</p><br>");
                            break;
                        default:
                            break;
                    }
                }
            ?>

            <form action="" class="mx-5 d-inline" method="get">
                <input class="form-control w-25 d-inline" name="buscador" type="text" placeholder="Marca o Modelo...">
                <button class="btn btn-primary d-inline" type="submit">Buscar</button>
            </form>
            <div id="listado" class="mt-5 m-5">
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

                            if(isset($_GET['buscador'])){
                                $buscador = $_GET['buscador'];
                                $productos = $productoService->findAllWithCategoryName($buscador);
                            }else{
                                $productos = $productoService->findAllWithCategoryName("");
                            }
                            foreach($productos as $producto){;
                                echo ("
                                    <tr>
                                        <td><img src='$producto->imagen' alt='Imagen de producto' style='width:150px; height:80px'></td>
                                        <td class='pt-4'>$producto->id</td>
                                        <td class='pt-4'>$producto->marca</td>
                                        <td class='pt-4'>$producto->modelo</td>
                                        <td class='pt-4'>$producto->categoriaNombre</td>
                                        <td class='pt-4'>$producto->stock ud.</td>
                                        <td class='pt-4'>$producto->descripcion</td>
                                        <td class='pt-4'>$producto->precio €</td>
                                        <td class='pt-4'><div>
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