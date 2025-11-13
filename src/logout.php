<?php
    //Esto es un servicio, no un html
    require_once dirname(__FILE__) . "/../src/services/SessionService.php";

    use services\SessionService;

    $sessionService = new SessionService();
    $sessionService->logout();
    header("Location:index.php");
?>