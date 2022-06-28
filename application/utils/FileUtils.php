<?php
function getRandomFileNm($filename) {

    return gen_uuid_v4() . "." . getExt($filename);
}


function getExt($fileName) {
        return pathinfo($fileName, PATHINFO_EXTENSION);

        // $file_name = explode(".", $fileName);
        // $ext = end($file_name); // 확장자
        // return $ext;

        // return end(explode(".", $fileName));
}

function gen_uuid_v4()
{
    return sprintf(
        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0xffff)
    );
}
