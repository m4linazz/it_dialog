<?php 

    ob_start();
    session_start([
        "cookie_lifetime" => 14400
    ]);

    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/db.class.php");
    require($_SERVER["DOCUMENT_ROOT"] . "/core/classes/base.class.php");

    DB::Connect()

?>