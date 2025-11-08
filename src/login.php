<?php
    include_once dirname(__FILE__) . "/../src/header.php";
    include_once dirname(__FILE__) . "/../src/footer.php";
?>
<html>
    <head>
        <title>Login</title>
        <link href="estilos.css" type="text/css" rel="stylesheet">
    </head>
    <body>
        <h1>Login</h1>
        <div>
            <form action="" method="post">
                <label for="username">Usuario: </label>
                <input type="text" name="username" placeholder="Username...">
                <label for="passwd">Contraseña: </label>
                <input type="password" name="passwd" placeholder="Password...">
                <button type="submit">Iniciar sesión</button>
                <button type="button">Registarse</button>
            </form>
        </div>
    </body>
</html>