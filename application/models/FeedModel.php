<?php
namespace application\controllers;
use PDO;

class FeedModel extends Controller {
    public function index() {
        $this->addAttribute(_MAIN, $this->getView("feed/index.php"));
        return "template/t1.php";
    }
}