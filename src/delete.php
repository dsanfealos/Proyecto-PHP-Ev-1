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

    if (isset($_GET['id'])){
        $id = $_GET['id'];

        $productoAEliminar = $prodService->findById($id);
        if ($productoAEliminar == null){
            header("Location:index.php?error=delete"); 
        }
        $imagen = $productoAEliminar->imagen;
        $prodService->deleteById($id);

        if (file_exists($imagen)){
            unlink($imagen);
        }

        header('Location:index.php?exito=delete');
    }else{
        header("Location:index.php?error=delete");        
    }
?>
