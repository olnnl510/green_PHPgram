<?php
require_once "application/utils/FileUtils.php";

$result = getRandomFileNm("rfjkhfsdajhdsfahjksdfakjhsfdakjhsfdkjfsdsdafjhkfsdajhkdsfakjhsdfakjhdsfakjhsfdajk.jpg");

print $result;



" SELECT A.ifeed, A.location, A.ctnt, A.iuser, A.regdt
, C.nm AS writer, C.mainimg
, IFNULL(E.cnt, 0) AS favCnt
, if(F.ifeed IS NULL, 0, 1) AS isFav
FROM t_feed A
INNER JOIN t_user C
ON A.iuser = C.iuser
LEFT JOIN (
  SELECT ifeed, COUNT(ifeed) AS cnt
  FROM t_feed_fav
  GROUP BY ifeed
) E
ON A.ifeed = E.ifeed
LEFT JOIN (
  SELECT ifeed
  FROM t_feed_fav
  WHERE iuser = :iuser
) F
ON A.ifeed = F.ifeed
ORDER BY A.ifeed DESC
LIMIT :startIdx, :feedItemCnt
";