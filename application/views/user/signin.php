<!DOCTYPE html>
<html lang="en">
<?php include_once "application/views/template/head.php"; ?>
<body class="h-full container-center">
    <div>
        <h1>로그인</h1>
        <div class="err">
            <?php
            if(isset($_GET["err"])) {
                print "로그인을 할 수 없습니다.";
            }
            ?>
        </div>
        <form action="signin" method="post">
            <div><input type="email" name="email" placeholder="email" value="<?=isset($_GET['email']) ? $_GET['email'] : ""?>" autofocus required></div>
            <div><input type="password" name="pw" placeholder="password" required></div>
            <div>
                <input type="submit" value="로그인">
            </div>
        </form>
        <div>
            <a href="signup">회원가입</a>
        </div>
    </div>
</body>
</html>

<!--

param('email') 이렇게만 적어도
isset($_GET['email']) ? $_GET['email'] : ""
이것과 같은 효과 나도록 만듦

-->