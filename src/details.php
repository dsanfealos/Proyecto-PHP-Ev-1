<?php
    include_once dirname(__FILE__) . "/../src/header.php";
    include_once dirname(__FILE__) . "/../src/footer.php";
    require_once dirname(__FILE__) . "/../src/services/ProductosService.php";
    include_once dirname(__FILE__) . "/../src/services/CategoriasService.php";
    include_once dirname(__FILE__) . "/../src/config/Config.php";

    use services\CategoriasService;
    use config\Config;
    use services\ProductosService;

    $config = Config::getInstance();
    $prodService = new ProductosService($config->db);
    $categService = new CategoriasService($config->db);

    $id = 0;
    $marca = "";
    $modelo = "";
    $precio = 0;
    $categoria = "";
    $descripcion = "";
    $imagen = "";
    $stock = 0;
    if (isset($_GET['id'])){
        $id = $_GET['id'];

        $productoAMostrar = $prodService->findById($id);
        $marca = $productoAMostrar->marca;
        $modelo = $productoAMostrar->modelo;
        $precio = $productoAMostrar->precio;
        $categoria = $categService
            ->findById($productoAMostrar->categoriaId)
            ->nombre;
        $descripcion = $productoAMostrar->descripcion;
        $imagen = $productoAMostrar->imagen;
        $stock = $productoAMostrar->stock;
    }else{
        echo "<p class='bg-danger p-3 mt-3 rounded text-white'>Ha habido un error al cargar el producto.</p><br>";
    }
?>
<html>
    <head>
        <title>Detalles Producto</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
            rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
            crossorigin="anonymous">
    </head>
    <body class="m-5 pb-4">
        <h2 class="text-center mt-4">Detalles de Producto</h2>
        <div>
            <label for="" class="fw-bold">Id: </label>
            <p class="d-inline"><?php echo $id ?></p>
        </div>
        <div>
            <label for="" class="fw-bold">Marca: </label>
            <p class="d-inline"><?php echo $marca ?></p>
        </div>
        <div>
            <label for="" class="fw-bold">Modelo: </label>
            <p class="d-inline"><?php echo $modelo ?></p>
        </div>
        <div>    
            <label for="" class="fw-bold">Descripción: </label>
            <p class="d-inline"><?php echo $descripcion ?></p>
        </div>
        <div>    
            <label for="" class="fw-bold">Precio: </label>
            <p class="d-inline"><?php echo $precio . " €" ?></p>
        </div>
        <div>    
            <label for="" class="fw-bold">Categoría: </label>
            <p class="d-inline"><?php echo $categoria ?></p>
        </div>
        <div>    
            <label for="" class="fw-bold">Stock: </label>
            <p class="d-inline"><?php echo $stock . " ud." ?></p>
        </div>
        <div>    
            <label for="" class="fw-bold">Imagen: </label>
            <p class="d-inline"><?php echo $imagen ?></p>
        </div>
        <button class="btn btn-primary mt-5"><a href="/" class="text-white text-decoration-none">Volver</a></button>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
            crossorigin="anonymous"></script>
    </body>
</html>