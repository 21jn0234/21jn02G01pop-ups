<?php
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!empty($_SESSION['puser'])){
        $member = $_SESSION['puser'];
    }
?>
<link rel="stylesheet" href="css/hamburger-menu.css">
<script src="dist/js/hamburger-menu.js"></script>
<header style="background-color:aquamarine;">
    <div class="header">
        <div class="haburger">
            <button class="hamburger-button">
            </button>
            <nav class="hamburger-nav">
                <ul>
                    <?php if(isset($member)) : ?>
                        <h2 class="menu">会員サービス・ヘルプ</h2>
                        <li class="menu"><a href="mypage.php"><h1>マイページ</h1></a></li>
                        <li class="menu"><a href="wantList_now.php"><h1>お気に入り（欲しリス）</h1></a></li>
                        <h2 class="menu">商品を探す</h2>
                        <li class="menu"><a href="listall.php"><h1>商品一覧</h1></a></li>
                        <li class="menu"><a href="search_genre.php"><h1>ジャンルから探す</h1></a></li>
                        <li class="menu"><a href="search_tenpo.php"><h1>お店から探す</h1></a></li>
                        <li class="menu"><a href="ranking.php"><h1>ランキング</h1></a></li>
                    <?php else: ?>
                        <h2 class="menu">会員サービス・ヘルプ</h2>
                        <li class="menu"><a href="login.php"><h1>ログイン</h1></a></li>
                        <h2 class="menu">商品を探す</h2>
                        <li class="menu"><a href="listall.php"><h1>商品一覧</h1></a></li>
                        <li class="menu"><a href="search_genre.php"><h1>ジャンルから探す</h1></a></li>
                        <li class="menu"><a href="search_tenpo.php"><h1>お店から探す</h1></a></li>
                        <li class="menu"><a href="ranking.php"><h1>ランキング</h1></a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
        <div class="hosi">
            <a href="wantList_now.php">
                <img src="images/newHeaderHoshi03.PNG" alt="ほしリスマーク"width="90" height="90" />
            </a>
        </div>

        <div class="logo">
            <a href="top.php">
                <img src="images/Logo_blackStrow.PNG" alt="Logoロゴ" width="384" height="90"/>
            </a>
        </div>
        <div class="search">
            <div class="kensaku">
            <form id="form1" action="search_results.php">
                <input id="sbox" name="keyword" type="text"style="width: 420px; height: 50px; "name="search" placeholder="キーワードを入力" />
                <input id="sbtn" type="submit"style="width: 60px; height: 55px;"value="🔎"/>
            </form>
            </div>
            <div class="syohin">
                <input id="pbtn" type="button" onclick="location.href='search_conditions.php'" style="width: 200px; height: 55px;"value="商品詳細検索"/>
            </div>
        </div>
        
        <?php if(isset($member)) : ?>
            <div  class="mypage">
                <a href = "mypage.php"><img src="images/MypageButton.PNG" alt="mypagebutton"width="140" /></a>
            </div>
        <?php else: ?>
            <div  class="login">
                <a href = "login.php"><img src="images/LoginButton.PNG" alt="loginbutton"width="140" /></a>
            </div>
        <?php endif; ?>
        
    </div>
    <hr>
</header>
