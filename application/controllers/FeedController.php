<?php

namespace application\controllers;

class FeedController extends Controller
{
    public function index()
    {
        $this->addAttribute(_JS, ["feed/index", "https://unpkg.com/swiper@8/swiper-bundle.min.js"]);
        $this->addAttribute(_CSS, ["feed/index", "https://unpkg.com/swiper@8/swiper-bundle.min.css"]);
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
                    "iuser" => $iuser
                ];
                $ifeed = $this->model->insFeed($param); // ☆☆☆☆☆

                $paramImg = ["ifeed" => $ifeed];
                foreach ($_FILES["imgs"]["name"] as $key => $originFileNm) {

                    $saveDirectory = _IMG_PATH . "/feed/" . $ifeed;
                    if (!is_dir($saveDirectory)) {
                        mkdir($saveDirectory, 0777, true);
                    }
                    $tempName = $_FILES['imgs']['tmp_name'][$key];
                    $randomFileNm = getRandomFileNm($originFileNm);
                    if (move_uploaded_file($tempName, $saveDirectory . "/" . $randomFileNm)) {
                        //chmod($saveDirectory . "/test." . $ext, octdec("0666"));
                        //chmod("C:/Apache24/PHPgram/static/img/profile/1/test." . $ext, 0755);
                        $paramImg["img"] = $randomFileNm;
                        $this->model->insFeedImg($paramImg);
                    }
                }
                return ["result" => 1];


            case _GET:
                $page = 1;
                if (isset($_GET["page"])) {
                    $page = intval($_GET["page"]);
                }
                $startIdx = ($page - 1) * _FEED_ITEM_CNT;
                $param = [
                    "startIdx" => $startIdx,
                    "iuser" => getIuser()
                ];
                $list = $this->model->selFeedList($param);
                foreach ($list as $item) {
                    $item->imgList = $this->model->selFeedImgList($item); // $item에 imgList 라고하는 변수를 만들고
                }
                return $list;
        }
    }
    public function fav() {
        $urlPaths = getUrlpaths();
        if(!isset($urlPaths[2])) {
            exit();
        }
        $param = [
            "ifeed" => intval($urlPaths[2]),
            "iuser" => getIuser()
        ];

        switch (getMethod()) {
            case _POST:
                return [_RESULT => $this->model->insFeedFav($param)];
            case _DELETE:
                return [_RESULT => $this->model->delFeedFav($param)];
        }
    }
}

// 트랜잭션 : 여러가지 작업이 있을 때 한가지로 묶어주는 작업

// ex) ATM기 2개의 업무가 한 업무

// /feed/fav/8 (post) : 등록
// /feed/fav/8 (delete) : 취소

// UrlUtils.php
// getUrlPaths

// /feed/fav/8
// 0번방/1번방/2번방