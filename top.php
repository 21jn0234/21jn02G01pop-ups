<?php
    require_once 'helpers/db_helper.php';

    
    $dbh=get_db_connect();
    $syohin_new_top5=solt_syohin_new_top5($dbh);
    $select_genre_all_new=select_genre_all_new_top5($dbh);
    $select_tenpo_all_new=select_tenpo_all_new_top5($dbh);

    session_start();
    // ログイン中なら、セッション変数の会員情報を取得する
        if(empty($_SESSION['puser'])){
            $puserID = null;
        }else if(isset($_SESSION['puser'])){
            $puser=$_SESSION['puser'];
            $puserID=$puser['userId'];
    
        }
?>
<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
 	<meta charset="utf-8"> 
 	<title>トップページ</title>
    <link rel="stylesheet" href="css/top.css">
    <!--<link rel="stylesheet" href="css/background2.css">-->
    <!--<link rel="stylesheet" href="css/background3.css">-->

    <script src="./jquery-3.6.0.min.js"></script>
    <!--<script src="dist/js/background2.js"></script>-->
</head> 
<body style="background-color:#e0ccab;"><?php include 'header.php' ?>
<div class="notice_slider_a">
    <div class="notice">
        <h1>❕お知らせ</h1>
        <div class="notice_a">
        <div style="height:380px; width:700px; overflow-y:scroll;">
        <?php if(is_null($puserID)){ ?><!-- 未ログイン状態なら -->
            <hr/>
            <p>ログインしていないです…。</p>
            <hr/>
        <?php }?> 
        <?php if(!is_null($puserID)){ ?><!-- ログイン状態なら -->
            <table id="news">
                <tr>
                    <td>
                    <?php $osirase = osirase_get($dbh,$puserID)?>
                    <!-- お知らせが無いとき -->
                    <?php if($osirase==null||is_null($osirase)){ ?>
                        <hr />
                        現在表示できるお知らせはありません…。
                    <?php } ?>
                    <!-- お知らせがあるとき -->
                    <?php foreach($osirase as $osi) : ?>
                        <?= $osi['newsDate'] ?><br>
                        <?php if($osi['newsflag'] == "7"){ ?>
                            
                            <?= $osi['syohinName'] ?>の販売終了７日前です！
                            
                            
                        <?php } ?>
                        <?php if($osi['newsflag'] == "3"){ ?>
                            
                            <?= $osi['syohinName'] ?>の販売終了３日前です！
                            
                            
                        <?php } ?>
                        <?php if($osi['newsflag'] == "0"){ ?>
                            
                            <?= $osi['syohinName'] ?>の販売終了が迫っています！
                            
                            
                        <?php }?>
                        
                    </td>
                    <hr/>
                </tr>
                <?php endforeach ?>
            </table>
            <hr/>
        <?php } ?>
        </div>
        </div>
    </div>
    
    <!--画像スライダーするやつ-->
    <div class="slider_a">
    <table>
    <td width="480" height="480">
    <!--jquery読み込んでる(多分)-->
    <p><link rel="stylesheet" href="css/bxslider.css">
    <!--<p><link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('.slider').bxSlider({
                auto: true,
                pause: 5000,
            });
        });
    </script>
    <div class="slider"><!--元々用意されてるClassだから自分のCSSに足す必要は多分ない-->
        <?php foreach($syohin_new_top5 as $syohin_new_top5_a) : ?>
          
            
            <?php if(is_null($syohin_new_top5_a['photo'])||$syohin_new_top5_a['photo']==""){ ?>
                <!--画像がない時の画像を表示-->
                <a href="Product_detail.php?syohinId=<?=$syohin_new_top5_a['syohinId']?>">
                <img src="images/no_image.png" width='480' height="480"/>
            </a>
            <?php }else{ ?>
                <a href="Product_detail.php?syohinId=<?=$syohin_new_top5_a['syohinId']?>">
                <img src = "images/<?= $syohin_new_top5_a['photo']?>"width='480' height="480" />
            </a>
            <?php } ?>
            
        <?php endforeach ?>
    </div>
</div>
    <td width="170" height="400">
    </td>
    </table>
    </div>
    <div class="idou">
        <div class="ranking">
            <a href="ranking.php">
                <img src="images/ranking.PNG" alt="ランキング"width="384" height="180">
            </a><br>
            <a href="ranking.php">ランキング</a>
        </div>
        <div class="hosi_now">
            <a href="./wantList_now.php">
                <img src="images/wantList_now.PNG" alt="欲しいものリスト（販売中）" width="384" height="180">
            </a><br>
            <a href="./wantList_now.php">欲しいものリスト（販売中）</a>
        </div>
        <div class="hosi_end">
            <a href="./wantList_end_css.php">
                <img src="images/wantList_end.PNG" alt="欲しいものリスト（終了）" width="384" height="180">
            </a><br>
            <a href="./wantList_end_css.php">欲しいものリスト（終了）</a>
        </div>
    </div>
    <div class="tenpo">
        <div class="tenpo_name">
        <h1>ジャンルで探す</h1><br>
        </div>
        <div class="tenpo_more">
        </div>
    </div>
    <div class="genre_new_5">
        <?php foreach($select_genre_all_new as $select_genre_all_new_a) : ?>
            <div class="genre_new">
                <tr>
                    <td>
                        <div class="connection_product_image">
                            <a href="search_results.php?genreCode=<?=$select_genre_all_new_a['genreCode']?>">
                            <?php if(is_null($select_genre_all_new_a['photo'])||$select_genre_all_new_a['photo']==""){ ?>
                                <!--画像がない時の画像を表示-->
                                <img src="images/no_image.png" width='240' height="240"/>
                            <?php }else{ ?>
                                <img src = "images/<?= $select_genre_all_new_a['photo']?>" width = '240' height = '240' />
                            <?php } ?>
                        </div>
                        </a>
                        <a href="search_results.php?genreCode=<?=$select_genre_all_new_a['genreCode']?>">
                        <?php print mb_strimwidth($select_genre_all_new_a['genreName'] , 0, 20, '…', 'UTF-8' );?>
                        </a><br>
                    </td>
                </tr>
            </div>
        <?php endforeach ?>
        <a href="./search_genre.php" calss="see_more">
            <image src="images/button_motto.png" weight="120" height="100">
        </a>
    </div>
    <div class="tenpo">
        <div class="tenpo_name">
            <h1>お店で探す</h1><br>
        </div>
    </div>
        <div class="tenpo_new_5">
        
            <?php foreach($select_tenpo_all_new as $select_tenpo_all_new_a) : ?>
                <div class="tenpo_new">
                        <td>
                            <div class="connection_product_image">
                            
                                <a href="search_results.php?tenpoCode=<?=$select_tenpo_all_new_a['tenpoCode']?>">
                                <?php if(is_null($select_tenpo_all_new_a['photo'])||$select_tenpo_all_new_a['photo']==""){ ?>
                                    <!--画像がない時の画像を表示-->
                                    <img src="images/no_image.png" width='240' height="240"/>
                                <?php }else{ ?>
                                    <img src = "images/<?=$select_tenpo_all_new_a['photo']?>" width = '240' height = '240' />
                                <?php } ?>
                            </div>
                            </a>
                            <a href="search_results.php?tenpoCode=<?=$select_tenpo_all_new_a['tenpoCode']?>">
                                <?php print mb_strimwidth($select_tenpo_all_new_a['tenpoName'] , 0, 20, '…', 'UTF-8' );?>
                            </a><br>
                        </td>
                    </tr>
                </div>
            <?php endforeach ?>
                <a href="./search_tenpo.php" calss="see_more">
                    <image src="images/button_motto.png" weight="120" height="100">
                </a>
        </div>
    
    <div class="tenpo">
        <div class="tenpo_name">
            <h1>新着商品</h1><br>
        </div>
        <div class="tenpo_more">
        </div>
    </div>
    <div class="syohin_new_5">
        
        <?php foreach($syohin_new_top5 as $syohin_new_top5_a) : ?>
            <div class="syohin_new">
            <tr>
                <td>
                    <div class="connection_product_image">
                        <a href="Product_detail.php?syohinId=<?=$syohin_new_top5_a['syohinId']?>">
                        <?php if(is_null($syohin_new_top5_a['photo'])||$syohin_new_top5_a['photo']==""){ ?>
                            <!--画像がない時の画像を表示-->
                            <img src="images/no_image.png" width='240' height="240"/>
                        <?php }else{ ?>
                            <img src = "images/<?= $syohin_new_top5_a['photo']?>" width = '240' height = '240' />
                        <?php } ?>
                    </div>
                    </a>
                    <a href="Product_detail.php?syohinId=<?=$syohin_new_top5_a['syohinId']?>">商品名：
                    <?php print mb_strimwidth($syohin_new_top5_a['syohinName'] , 0, 20, '…', 'UTF-8' );?></a><br>
                    <a href="Product_detail.php?syohinId=<?=$syohin_new_top5_a['syohinId']?>">値段：<?=$syohin_new_top5_a['price']?>円</a><br>
                </td>
            </tr>
            </div>
        <?php endforeach ?>
                <a href="./listall.php" calss="see_more">
                    <image src="images/button_motto.png" weight="120" height="100">
                </a>
    </div>


  
</div>
</body>
</html>