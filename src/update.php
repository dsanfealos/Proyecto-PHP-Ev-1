<?php
    require_once dirname(__FILE__) . "/../src/services/ProductosService.php";
    include_once dirname(__FILE__) . "/../src/services/CategoriasService.php";
    include_once dirname(__FILE__) . "/../src/config/Config.php";

    use services\CategoriasService;
    use config\Config;
    use services\ProductosService;

    $config = Config::getInstance();
    $prodService = new ProductosService($config->db);
    $categService = new CategoriasService($config->db);

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


    $listaCategorias = $categService->findAll();

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

        $productoAModificar = $prodService->findById($id);
        $marca = $productoAModificar->marca;
        $modelo = $productoAModificar->modelo;
        $precio = $productoAModificar->precio;
        $categoria = $categService
            ->findById($productoAModificar->categoriaId)
            ->nombre;
        $descripcion = $productoAModificar->descripcion;
        $imagen = $productoAModificar->imagen;
        $stock = $productoAModificar->stock;
    }else{
        header("Location:index.php?error=update");
    }
    

    include_once dirname(__FILE__) . "/../src/header.php";
    include_once dirname(__FILE__) . "/../src/footer.php";

    if (isset($_POST['modelo'])){
        try{
            $productoAModificar->marca = $_POST['marca'];
            $productoAModificar->modelo = $_POST['modelo'];
            $productoAModificar->precio = $_POST['precio'];
            $categoria = $_POST['categoria'];
            $productoAModificar->descripcion = $_POST['descripcion'];
            $productoAModificar->stock = $_POST['stock'];
            $productoAModificar->categoriaId = $categService->findByName($categoria)->id;

            $prodService->update($productoAModificar);
            
            $marca = $productoAModificar->marca;
            $modelo = $productoAModificar->modelo;
            $precio = $productoAModificar->precio;
            $descripcion = $productoAModificar->descripcion;
            $imagen = $productoAModificar->imagen;
            $stock = $productoAModificar->stock;
            echo("<p class='bg-success p-3 mt-3 rounded text-white'>El producto con modelo $modelo ha sido modificado con éxito.</p><br>");
        }catch(Exception $e){
            echo("<p class='bg-danger p-3 mt-3 rounded text-white'>Ha habido un error al modificar el producto.</p><br>");
        }
    }

?>
<html>
    <head>
        <title>Modificar Producto</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
            rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
            crossorigin="anonymous">
    </head>
    <body class="m-5 pb-4">
        <h2 class="text-center mt-4">Modificar Producto</h2>
        
        <form class="m-4" action="" method="POST" enctype="multipart/form-data">
            <h3>Producto con id: <?php echo($id . "<br>") ?></h3>
            <div class="mb-3">
                <label class="form-label" for="">Marca: </label>
                <?php
                    echo("<input class='form-control' type='text' name='marca' value='$marca'>");
                ?>                
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Modelo: </label>
                <?php
                    echo("<input class='form-control' type='text' name='modelo' value='$modelo'>");
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Precio: </label>
                <?php
                    echo("<input class='form-control' type='number' min='0' step='0.01' name='precio' value='$precio'>");
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Categoria: </label>
                <select class="form-control" name="categoria">
                    <?php
                        foreach($listaCategorias as $categoriaSuelta){
                            $nombreCat = $categoriaSuelta->nombre;
                            $selected = $nombreCat === $categoria ? 'selected':'';
                            echo("<option value='$nombreCat' $selected>$nombreCat</option>");
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Descripción: </label>
                <?php
                    echo("<input class='form-control' type='text' name='descripcion' value='$descripcion'>");
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Imagen: </label>
                <?php
                    echo("<input class='form-control' type='text' name='imagen-ruta' disabled='true' value='$imagen'>");
                ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="">Stock: </label>
                <?php
                    echo("<input class='form-control' type='number' min='0' name='stock' value='$stock'>");
                ?>
            </div>
            <button class="btn btn-success" type="Submit">Modificar</button>
        </form>
        <button class="btn btn-primary mt-5"><a href="/" class="text-white text-decoration-none">Volver</a></button>
        

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
        <script>
            window.addEventListener('DOMContentLoaded', ()=>{
                new bootstrap.Modal('#modalPrueba').show();
            })
        </script>
    </body>
</html>