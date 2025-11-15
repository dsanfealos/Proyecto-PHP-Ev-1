<?php
    include_once dirname(__FILE__) . "/../src/config/Config.php";
    require_once dirname(__FILE__) . "/../src/services/ProductosService.php";
    require_once dirname(__FILE__) . "/../src/models/Producto.php";

    use config\Config;
    use services\ProductosService;
    use models\Producto;

    $config = Config::getInstance();
    $prodService = new ProductosService($config->db);

    $id = 0;

    //Sólo gestión
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        if(!isset($_GET['id'])){
            echo "No se ha encontrado el producto asociado";
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
                $nuevoNombre = time() . '.' . $extension;
                $rutaDestino = __DIR__ . '/uploads/' . $nuevoNombre;
                $rutaAcceso = 'uploads/' . $nuevoNombre;

                
                if(move_uploaded_file($tmpRuta, $rutaDestino)){
                    $producto = $prodService->findById($id);
                    $producto->imagen = $rutaAcceso;
                    $prodService->update($producto);
                    header("Location:index.php");
                    
                }else{
                    echo "Error al subir archivo o al moverlo.<br>";
                }
            }else{
                echo "El fichero no tiene una estensión no permitida. Sólo pueden subirse ficheros .jpg, .jpeg y .png.";
            }
        }else{
            echo "Error al subir el archivo.<br>";
        }
    }
?>