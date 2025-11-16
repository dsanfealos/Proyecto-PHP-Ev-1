<?php
    require_once dirname(__FILE__) . "/../src/services/ProductosService.php";
    require_once dirname(__FILE__) . "/../src/config/Config.php";

    use config\Config;
    use services\ProductosService;

    $config = Config::getInstance();
    $prodService = new ProductosService($config->db);

    $rol = "";
    if (isset($_COOKIE['rol'])){
        if ($_COOKIE['rol'] == 'ADMIN'){
            $rol = $_COOKIE['rol'];
        }
    }

    if($rol != 'ADMIN'){
        header("Location:index.php?permission=0");
        return;
    }

    $id = 0;
    $imagen = "";
    if (isset($_GET['id'])){
        $id = $_GET['id'];

        $productoAModificar = $prodService->findById($id);
        $marca = $productoAModificar->marca;
        $modelo = $productoAModificar->modelo;
        $imagen = $productoAModificar->imagen;
    }else{
        header("Location:index.php?error=imagen-form"); 
    }
    

    include_once dirname(__FILE__) . "/../src/header.php";
    include_once dirname(__FILE__) . "/../src/footer.php";
?>
<html>
    <head>
        <title>Cambiar Imagen</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
            rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
            crossorigin="anonymous">
    </head>
    <body class="m-5 pb-4">
        <h2 class="text-center mt-4">Modificar Imagen</h2>
        <?php
            echo("
                <form class='m-4' action='update_image_file.php?id=$id' method='POST' enctype='multipart/form-data'>
                    <div class='mb-3'>
                        <label class='form-label' for=''>Producto con id: </label>
                        <input class='form-control' type='text' name='id' disabled='true' value='$id'>
                    </div>
                    <div class='mb-3'>
                        <label class='form-label' for=''>Marca: </label>
                        <input class='form-control' type='text' name='id' disabled='true' value='$marca'>
                    </div>
                    <div class='mb-3'>
                        <label class='form-label' for=''>Modelo: </label>
                        <input class='form-control' type='text' name='modelo' disabled='true' value='$modelo'>
                    </div>
                    <div class='mb-3'>
                        <label class='form-label' for=''>Imagen actual: </label>
                        <input class='form-control' type='text' name='imagen-ruta' disabled='true' value='$imagen'>
                    </div>
                    <div class='mb-3'>
                        <label class='form-label' for=''>Nueva imagen: </label>
                        <input class='form-control' type='file' accept='image/png, image/jpg, image/jpeg' name='imagen-fichero'>
                    </div>
                    <button class='btn btn-success' type='submit'>Modificar</button>
                </form>
            ");
        ?>
        <button class="btn btn-primary mt-5"><a href="/" class="text-white text-decoration-none">Volver</a></button>
        


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
            crossorigin="anonymous"></script>
    </body>
</html>