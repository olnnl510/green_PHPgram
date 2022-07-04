<?php
namespace application\controllers;

use application\libs\Application;

class UserController extends Controller {

    //로그인
    public function signin() {        
        switch(getMethod()) {
            case _GET:
                return "user/signin.php";
            case _POST:
                $email = $_POST["email"];
                $pw = $_POST["pw"];
                $param = [ "email" => $email ];
                $dbUser = $this->model->selUser($param);
                if(!$dbUser || !password_verify($pw, $dbUser->pw)) {                                                        
                    return "redirect:signin?email={$email}&err";
                }
                $dbUser->pw = null;
                $dbUser->regdt = null;
                $this->flash(_LOGINUSER, $dbUser);
                return "redirect:/feed/index";
            }
    }

    //회원가입
    public function signup() {
        switch(getMethod()) {
            case _GET:
                return "user/signup.php";
            case _POST:
                $email = $_POST["email"];
                $pw = $_POST["pw"];
                $hashedPw = password_hash($pw, PASSWORD_BCRYPT);
                $nm = $_POST["nm"];
                $param = [
                    "email" => $email,
                    "pw" => $hashedPw,
                    "nm" => $nm
                ];

                $this->model->insUser($param);

                return "redirect:signin";
        }
    }

    public function logout() {
        $this->flash(_LOGINUSER);
        return "redirect:/user/signin";
    }

    public function feedwin() {
        $iuser = isset($_GET["iuser"]) ? intval($_GET["iuser"]) : 0;
        $param = [ "feediuser" => $iuser, "loginiuser" => getIuser() ];
        $this->addAttribute(_DATA, $this->model->selUserProfile($param));
        
        $this->addAttribute(_JS, ["user/feedwin", "https://unpkg.com/swiper@8/swiper-bundle.min.js"]);
        $this->addAttribute(_CSS, ["user/feedwin", "https://unpkg.com/swiper@8/swiper-bundle.min.css", "feed/index"]);        
        $this->addAttribute(_MAIN, $this->getView("user/feedwin.php"));
        return "template/t1.php"; 
    }

    public function feed() {
        if(getMethod() === _GET) {    
            $page = 1;
            if(isset($_GET["page"])) {
                $page = intval($_GET["page"]);
            }
            $startIdx = ($page - 1) * _FEED_ITEM_CNT;
            $param = [
                "startIdx" => $startIdx,
                "iuser" => $_GET["iuser"]
            ];        
            $list = $this->model->selFeedList($param); // model 이라는 멤버필드에 static 안붙어있음
            foreach($list as $item) {                 
                $item->imgList = Application::getModel("feed")->selFeedImgList($item);
            }
            return $list;
        }
    }

    public function follow() {    
         
        $param = [
            "fromiuser" => getIuser()
        ];

        switch(getMethod()) {
            case _POST:                                
                $json = getJson();
                $param["toiuser"] = $json["toiuser"];
                return [_RESULT => $this->model->insUserFollow($param)];
            case _DELETE:        
                $param["toiuser"] = $_GET["toiuser"];
                return [_RESULT => $this->model->delUserFollow($param)];
        }
    }
}



/*

메소드를 만들껀데,
객체에 static이 안붙은 멤버필드를 사용할껀데
메소드에 statix 붙이면 X

객체 생성했을 때 같은값ㅇ

☆객체마다 다른값 넣고 싶으면 static 붙이면 안됨.☆
*/