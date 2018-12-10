<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 20:32
 */
/*
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar3/" : "/id1354/seminar3/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar3/" : str_replace("\\", "/", __DIR__)."/");

include_once "./controllers/recipeController.php";
include_once "./controllers/userController.php";
include_once "./controllers/commentController.php";

$recipeController = new RecipeController(RecipeController::USE_XML);
var_dump(UserController::create("test", "test@test.test", "test"));
var_dump(CommentController::create("test", 1, 1));

?>
<pre>
<?php
var_dump($recipeController->getRecipeByUrlName('meatballs'));
?>
</pre>
*/

include "./integration/dbConnection.php";

$DB = new dbConnection();
$sSQL = "DELETE FROM recipe WHERE 1 = 1";
var_dump($DB->runQuery($sSQL, array()));
