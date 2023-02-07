<?php
    require './helpers/db_helper.php';
    $dbh=get_db_connect();

    // セッションを開始する
    session_start();

    // 未ログインの場合login.phpに遷移する
    // ログイン中なら、セッション変数の会員情報を取得する
    if(empty($_SESSION['puser'])){
        header('Location:login.php');
        exit;
    }else if(isset($_SESSION['puser'])){
        $puser=$_SESSION['puser'];
        $puserID=$puser['userId'];
        
        // 販売終了の_次元配列
        $wantlist_end=select_wantList_end($dbh,$puserID);

    }

?>

<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8"> 
        <title>欲しいものリスト</title> 

        <script src="./jquery-3.6.0.min.js"></script>
        <script src="./jquery-3.6.0.js"></script>

        <link rel="stylesheet" href="css/wantList.css">
        
    </head>

    <body bgcolor="#C6C0BC">

        <?php include 'header.php' ?>
        <div class="pagePast">
        <?php include 'wantList_middle.php' ?>
        <br>

        <?php
            if($wantlist_end==null){    ?>
                表示できる商品がないようです。<br>
                <a href="./listall.php">欲しいものを探してみませんか？</a>
        <?php }else{ ?>

        <?php foreach($wantlist_end as $hosii_mono): ?>
            <table align="left" class="table">
                <!-- 商品の画像表示 -->
                <tr>
                    <td id="product_image">
                        <a href="Product_detail.php?syohinId=<?=$hosii_mono['syohinId']?>">
                            <div class="relative">
                            <?php if(is_null($hosii_mono['photo'])||$hosii_mono['photo']==""){ ?>
                                <!--画像がない時の画像を表示-->
                                <img src="images/no_image.png ?>" width="120" height="120" />
                            <?php }else{ ?>
                                <!--画像がある時 -->
                                <img src="images/<?=$hosii_mono['photo'] ?>" width="120" height="120" />
                                <!-- 購入しているかどうかチェック -->
                                <?php } 
                                    $bought=select_boughtID_flag($dbh,$puserID,$hosii_mono['syohinId']);
                                    if(!(empty($bought))){ ?>
                                    <div class="ribbon">
                                        <img src="images/Ribbon_bought_120_120.PNG"/>
                                    </div>
                                </div>
                            <?php } ?>
                        </a>
                    </td>
                </tr>
                <!-- 商品の名前表示 -->
                <tr>
                    <td id="max_18ch">
                        <a href="Product_detail.php?syohinId=<?=$hosii_mono['syohinId']?>">
                            <?=$hosii_mono['syohinName'] ?>
                        </a>
                    </td>
                </tr>
                <!-- 復刻リクエストボタンを表示 -->
                <tr>
                    <td>
                        <!-- 復刻リクエストをしているかどうかチェック -->
                        <?php 
                         $reprint=select_reprintID_flag($dbh,$puserID,$hosii_mono['syohinId']);
                         // $rep_flag=$reprint['reprintId']; 
                         if(empty($reprint)){ ?>
                            <a href="reprintInsert_hoshirisu.php?userId=<?=$puserID?>&syohinId=<?=$hosii_mono['syohinId']?>">
                                <input type='button' value='復刻リクエスト' >
                            </a>
                        <?php }else{ ?>
                            <input type='button' value='復刻リクエスト済' disabled>
                        <?php } ?>
                    </td>
                </tr>
                <!-- 値段orレビューする！ボタンを表示する -->
                <!-- 購入していなければ値段を表示、購入していればレビューするボタンを表示 -->
                <tr>
                    <td>
                        <?php 
                            $bought=select_boughtID_flag($dbh,$puserID,$hosii_mono['syohinId']);
                            if(empty($bought)){ ?>
                                \<?=$hosii_mono['price'] ?>
                        <?php }else{ 
                            $review=select_reviewID_flag($dbh,$puserID,$hosii_mono['syohinId']);
                            if(empty($review)){ ?>
                                <form action="./review.php?syohinId=<?=$hosii_mono['syohinId'] ?>" method="POST">
                                    <input type="hidden" name="syohinid" value=<?=$hosii_mono['syohinId']?>>
                                    <input type=submit value="レビューをする！" />
                                </form>
                            <?php }else{ ?>
                                <input type='button' value='レビュー済' disabled>
                            <?php } ?>
                        <?php } ?>
                    </td>
                </tr>

            </table>
        <?php endforeach ?>
        <?php } ?>
        </div>
    </body>
    
</html>