<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 20:32
 */
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar2/" : "/id1354/seminar2/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar2/" : str_replace("\\", "/", __DIR__)."/");

include_once "./controllers/userController.php";

?>
<pre>
<?php
var_dump($user = UserController::get(4));
?>
</pre>
<?php

var_dump(UserController::authUser("test", 'test'));