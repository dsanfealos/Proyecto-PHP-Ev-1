<?php
    require_once dirname(__FILE__) . "/../src/services/SessionService.php";

    use services\SessionService;

    $sessionSvc = new SessionService();

    $loginDisplay = "inline";
    $logoutDisplay = "none";
    if (isset($_COOKIE['usuario'])){
        $loginDisplay = "none";
        $logoutDisplay = "inline";
    }
    $rol = "Invitado";
    if (isset($_COOKIE['rol'])){
        $rol = $_COOKIE['rol'];
    }
    
?>
<html>
    <body>
        <nav class="bg-secondary" style="height:75px">
            <img src="favicon.ico" class="d-inline h-100">
            <h2 class="d-inline mx-3">Trapos y zapatos</h2>
            <ul class="d-inline">
                <li class="d-inline"><a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="/">Home</a></li>
                <li class="d-inline"><a class="link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover" href="create.php">Crear Producto</a></li>
                <?php
                echo("
                    <li class='d-$loginDisplay'><a class='link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover' href='login.php'>Iniciar sesión</a></li>
                    <li class='d-$logoutDisplay'><a class='link-light link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover' href='logout.php'>Cerrar sesión</a></li>
                ");
                
                ?>
            </ul>
            <p class="float-end mt-4 mx-4 text-white"><?php echo $rol ?></p>
        </nav>
    </body>
</html>