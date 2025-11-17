<?php
    require_once dirname(__FILE__) . "/../src/config/Config.php";
    require_once dirname(__FILE__) . "/../src/services/ProductosService.php";
    require_once dirname(__FILE__) . "/../src/models/Producto.php";

    use config\Config;
    use services\ProductosService;
    use models\Producto;

    $config = Config::getInstance();
    $prodService = new ProductosService($config->db);

    $id = 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!isset($_GET['id'])){
            echo "<p class='bg-danger p-3 mt-3 rounded text-white'>No se ha encontrado el producto asociado</p>";
            return;
        }
        
        if (isset($_FILES['imagen-fichero']) && $_FILES['imagen-fichero']['error'] === UPLOAD_ERR_OK){
            $fichero = $_FILES['imagen-fichero'];
            $id = $_GET['id'];
            
            $nombre = $fichero['name'];
            $tipo = $fichero['type'];
            $tmpRuta = $fichero['tmp_name'];
            $error = $fichero['error'];

            $tiposPermitidos = ['image/jpeg', 'image/png'];
            $extensionesPermitidas = ['jpg', 'png', 'jpeg'];
            $infoFichero = finfo_open(FILEINFO_MIME_TYPE);
            $tipoDetectado = finfo_file($infoFichero, $tmpRuta);
            $extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

            if (in_array($tipoDetectado, $tiposPermitidos) && in_array($extension, $extensionesPermitidas)){
                $producto = $prodService->findById($id);

                $nuevoNombre = $producto->uuid . '.' . $extension;
                $rutaDestino = __DIR__ . '/uploads/' . $nuevoNombre;
                $rutaAcceso = 'uploads/' . $nuevoNombre;

                if (file_exists($rutaDestino)){
                    unlink($rutaDestino);
                }
                
                if(move_uploaded_file($tmpRuta, $rutaDestino)){
                    $producto->imagen = $rutaAcceso;
                    $prodService->update($producto);
                    header("Location:index.php?exito=imagen-upload");
                    
                }else{
                    header("Location:index.php?error=imagen-upload"); 
                }
            }else{
                header("Location:index.php?error=imagen-upload"); 
            }
        }else{
            header("Location:index.php?error=imagen-upload"); 
        }
    }
?>