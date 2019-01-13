<?php
/**
 * Created by PhpStorm.
 * User: Linus
 * Date: 2019-01-13
 * Time: 13:52
 */

class UserView {

    private $controller;

    /**
     * UserView constructor.
     *
     * @param UserController $UserController
     */
    public function __construct($UserController) {
        $this->controller = $UserController;
    }

    public function performUserAction(){
        $this->controller->setUserData($_POST['callee'], $_POST['username'], $_POST['password'], $_POST['email']);
        if (isset($_GET['action']) && !empty($_GET['action'])) {
            $this->controller->{$_GET['action']}();
        }
    }

    public function redirect(){
        $url = LINK_PATH.$this->controller->sReturnPage;
        if( count($this->controller->aReturnOptions) > 0) $url .= '?' . http_build_query($this->controller->aReturnOptions);
        header("Location: ".$url);
        die();
    }

}