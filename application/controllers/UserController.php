<?php

namespace application\controllers;

// require_once "application/utils/UrlUtils.php";

class UserController extends Controller
{
    public function signin()
    { // 로그인

        switch (getMethod()) {
            case _GET:
                return "user/signin.php";
            case _POST:
                $email = $_POST["email"];
                $pw = $_POST["pw"];
                $param = [
                        "email" => $email
                    ];

                $DbUser = $this->model->SelUser($param);

                if ($DbUser === false || !password_verify($pw, $DbUser->pw)) { // 비밀번호 다름
                    return "redirect:/signin?email={$email}&err";
                }
                return "redirect:/feed/index";

        }
    }

    public function signup()
    { // 회원가입 (join)
        // print getMethod(); // UrlUtils.php
        // return "user/signup.php";

        // if(getMethod() === _GET) {
        //     return "user/signup.php";
        // } else if (getMethod() === _POST) {
        //     return "redirect:signin";
        // }

        switch (getMethod()) {
            case _GET:
                return "user/signup.php";
            case _POST:
                $param = [
                    "email" => $_POST["email"],
                    "pw" => $_POST["pw"],
                    "nm" => $_POST["nm"],
                ];

                $param["pw"] = password_hash($param["pw"], PASSWORD_BCRYPT); // PASSWORD_BCRYPT: 복호화안되는 (다시 되돌릴 수 없는) 단방향 암호화 기법.
                $this->model->insUser($param);
                return "redirect:signin";
        }
    }
}
