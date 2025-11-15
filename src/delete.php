<?php
    require_once dirname(__FILE__) . "/../src/services/ProductosService.php";
    require_once dirname(__FILE__) . "/../src/config/Config.php";

    use config\Config;
    use services\ProductosService;

    $config = Config::getInstance();
    $prodService = new ProductosService($config->db);

    if (isset($_GET['id'])){
        $id = $_GET['id'];

        $productoAEliminar = $prodService->findById($id);
        $imagen = $productoAEliminar->imagen;
        $prodService->deleteById($id);

        if (file_exists($imagen)){
            unlink($imagen);
        }

        header('Location: ' . '/');
        //TODO: Mensaje de éxito (modal o en index.php)
    }else{
        echo "<p class='bg-danger p-3 mt-3 rounded text-white'>Ha habido un error al cargar el producto.</p><br>";
    }
?>
