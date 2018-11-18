<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 20:32
 */
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar2/" : "/id1354/seminar2/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar2/" : str_replace("\\", "/", __DIR__)."/");

include_once "./controllers/recipeController.php";
include_once "./controllers/userController.php";

$recipeController = new RecipeController(RecipeController::USE_XML);
UserController::create("test", "test@test.test", "test");

?>
<pre>
<?php
var_dump($recipeController->getRecipeByUrlName('meatballs'));
?>
</pre>