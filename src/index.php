<?php
    include_once dirname(__FILE__) . "/../src/header.php";
    include_once dirname(__FILE__) . "/../src/footer.php";
    include_once dirname(__FILE__) . "/../src/services/CategoriasService.php";
    include_once dirname(__FILE__) . "/../src/config/Config.php";

    use services\CategoriasService;
    use config\Config;
?>

<html>    
    <head>
        <title>Prueba</title>
        <link href="estilos.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <content>
            <?php
                echo "Buenas tardes.<br>";
                echo "Categorías: <br>";
                $config = Config::getInstance();

                $categoriasService = new CategoriasService($config->db);

                $categorias = $categoriasService->findAll();
                $count = 1;
                foreach($categorias as $categoria){
                    echo $count . " ";
                    $count++;
                    print_r($categoria->nombre);
                    echo "<br>";
                }
            ?>
            <button type="button">Click Me!</button>
            <div id="contenido-test">

            </div>
        </content>
    </body>
</html>