<?php

namespace application\controllers;

class FeedController extends Controller
{
    public function index()
    {
        $this->addAttribute(_JS, ["feed/index"]);
        $this->addAttribute(_MAIN, $this->getView("feed/index.php"));
        return "template/t1.php";
    }

    public function rest()
    {
        switch (getMethod()) {

            case _POST:
                if (!is_array($_FILES) || !isset($_FILES["imgs"])) {
                    return ["result" => 0]; // 0이 리턴되면 실패, 1이 리턴돼야 성공
                }
                $iuser = getIuser();
                $param = [
                    "location" => $_POST["location"],
                    "ctnt" => $_POST["ctnt"],
                    "iuser" => getIuser()
                ];
                $ifeed = $this->model->insFeed($param); // ☆☆☆☆☆

                // $num = 1;
                foreach ($_FILES["imgs"]["name"] as $key => $orginFileNm) {

                    $saveDirectory = _IMG_PATH . "/feed/" . $ifeed;
                    if (!is_dir($saveDirectory)) {
                        mkdir($saveDirectory, 0777, true);
                    }
                    $tempName = $_FILES['imgs']['tmp_name'][$key];
                    $randomFileNm = getRandomFileNm($orginFileNm);
                    if (move_uploaded_file($tempName, $saveDirectory . "/" . $randomFileNm)) {

                    $param = [
                        "ifeed" => $ifeed,
                        "img" => $randomFileNm
                    ];
                    $this->model->insFeedImg($param);
                    }
                }

                return ["result" => 1];
        }
    }
}



// 트랜잭션 : 여러가지 작업이 있을 때 한가지로 묶어주는 작업

// ex) ATM기 2개의 업무가 한 업무