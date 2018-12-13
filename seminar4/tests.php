<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2018-11-17
 * Time: 20:32
 */
/*
DEFINE("LINK_PATH", getenv("PRODUCTION") !== false ? "/seminar4/" : "/id1354/seminar4/");
DEFINE("APP_PATH", getenv( "PRODUCTION" ) !== false ? $_SERVER["DOCUMENT_ROOT"]."/seminar4/" : str_replace("\\", "/", __DIR__)."/");

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

$sadasd = "[
  {
    \"nr\": 1,
    \"instruction\": \"Get all the ingredients...\"
  },
  {
    \"nr\": 2,
    \"instruction\": \"Put the {4} in a large bowl.\"
  },
  {
    \"nr\": 3,
    \"instruction\": \"Add the {0}, {2} & {3} to the bowl and mix everything.\"
  },
  {
    \"nr\": 4,
    \"instruction\": \"Add the {1} and {5} and mix again.\"
  },
  {
    \"nr\": 5,
    \"instruction\": \"Roll your meatballs to your desired size.\"
  }
]";

var_dump(json_decode($sadasd));