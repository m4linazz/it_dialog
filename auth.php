<?php 

    $page = "Авторизация";

    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/init.class.php");

    include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/header.html");

    include($_SERVER["DOCUMENT_ROOT"] . "/tpl/auth/auth_header.html");
    include($_SERVER["DOCUMENT_ROOT"] . "/tpl/auth/auth_body.html");
    include($_SERVER["DOCUMENT_ROOT"] . "/tpl/auth/auth_footer.html");

    include($_SERVER["DOCUMENT_ROOT"] . "/tpl/system/footer.html");

?>