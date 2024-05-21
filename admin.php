<?php 

    $page = "Главная";

    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/init.class.php");

    if(isset($_SESSION["authed_user"])) {

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/header.html");
        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/menu.html");

        include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/footer.html");

    } else {

        header("Location: /auth");
        
    }

?>