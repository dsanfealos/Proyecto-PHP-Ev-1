<?php       
    require_once dirname(__FILE__) . "/../src/config/Config.php";
    require_once dirname(__FILE__) . "/../src/services/UsersService.php";
    require_once dirname(__FILE__) . "/../src/services/SessionService.php";
    require_once dirname(__FILE__) . "/../src/models/User.php";

    use models\User;
    use services\UsersService;
    use config\Config;
    use services\SessionService;

    if (isset($_POST['username']) && isset($_POST['passwd'])){  
        $username = $_POST['username'];
        $password = $_POST['passwd'];

        $config = Config::getInstance();
        $usersService = new UsersService($config->db);                
        $sessionService = SessionService::getInstance();
        $usuario = $usersService->authenticate($username, $password);
        if($usuario != null){
            $sessionService->login($usuario);
            header("Location:index.php");
        }
    }

    include_once dirname(__FILE__) . "/../src/header.php";
    include_once dirname(__FILE__) . "/../src/footer.php";
?>
<html>
    <head>
        <title>Login</title>
        <link rel="icon" type="image/x-icon" href="favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" 
            rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" 
            crossorigin="anonymous">
    </head>
    <body class="m-5">
        <h1 class="text-center mt-4">Login</h1>
        <div class="log-div m-4">
            <form action="" method="post" id="login-form" autocomplete="off">
                <div class="mb-3">
                    <label for="username" class="form-label">Usuario: </label>
                    <input type="text" class="form-control" name="username" value="" placeholder="Username...">
                </div>
                <div class="mb-3">
                    <label for="passwd" class="form-label">Contraseña: </label>
                    <input type="password" class="form-control" name="passwd"  value="" placeholder="Password...">
                </div>
                <button type="submit" class="btn btn-success">Iniciar sesión</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" 
            crossorigin="anonymous"></script>
    </body>
</html>