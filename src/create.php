<?php 
    include_once dirname(__FILE__) . "/../src/header.php";
    include_once dirname(__FILE__) . "/../src/footer.php";
    require_once dirname(__FILE__) . "/../src/services/ProductosService.php";
    require_once dirname(__FILE__) . "/../src/models/Producto.php";
    require_once dirname(__FILE__) . "/../src/services/CategoriasService.php";
    require_once dirname(__FILE__) . "/../src/config/Config.php";

    use services\CategoriasService;
    use models\Producto;
    use config\Config;
    use services\ProductosService;

    $config = Config::getInstance();
    $prodService = new ProductosService($config->db);
    $categService = new CategoriasService($config->db);

    $listaCategorias = $categService->findAll();

    if (isset($_POST['modelo'])){
        try{
            $marca = $_POST['marca'];
            $modelo = $_POST['modelo'];
            $precio = $_POST['precio'];
            $categoria = $_POST['categoria'];
            $descripcion = $_POST['descripcion'];
            $imagen = "";
            $stock = $_POST['stock'];

            $categoriaId = $categService->findByName($categoria)->id;
            $productoACrear = new Producto($marca, $modelo, $precio, 
                $categoriaId, $descripcion, $imagen, $stock);
            $prodService->save($productoACrear);

            echo("<p class='bg-success p-3 mt-3 rounded text-white'>El producto con modelo $modelo ha sido creado con éxito.</p><br>");
        }catch(Exception $e){
            echo ("<p class='bg-danger p-3 mt-3 rounded text-white'>Ha habido un error al crear el producto.</p><br>");
        }
    }
?>
<html>
    <head>
        <title>Crear Producto</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
            rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
            crossorigin="anonymous">
    </head>
    <body class="m-5">
        <h2 class="text-center mt-4">Crear un Producto</h2>
        <form class=" m-4" action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label" for="">Marca: </label>
                <input class="form-control" type="text" name="marca">
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Modelo: </label>
                <input class="form-control" type="text" name="modelo">
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Precio: </label>
                <input class="form-control" type="number" min="0" step="0.01" name="precio">
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Categoria: </label>
                <select class="form-control" name="categoria">
                    <?php
                        foreach($listaCategorias as $categoriaSuelta){
                            $nombreCat = $categoriaSuelta->nombre;
                            echo("<option value='$nombreCat'>$nombreCat</option>");
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Descripción: </label>
                <input class="form-control" type="text" name="descripcion">
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Imagen: </label>
                <input class="form-control" type="text" disabled="true" name="imagen-ruta">
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Stock: </label>
                <input class="form-control" type="number" min="0" name="stock">
            </div>
            <button class="btn btn-success" type="submit">Crear</button>
        </form>
        <button class="btn btn-primary mt-5"><a href="/" class="text-white text-decoration-none">Volver</a></button>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
            crossorigin="anonymous"></script>
    </body>
</html>