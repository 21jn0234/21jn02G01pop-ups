<?php
    require_once 'helpers/db_helper.php';

    
    $dbh=get_db_connect();
    $syohin = $_GET['syohinId'];
    $syohin_genre=select_syohin_genre($dbh,$syohin);
    $syohinId=select_syohin_db($dbh,$syohin);
    $tenpoCode=$syohinId['tenpoCode'];
    $genreCode=$syohinId['genreCode'];
    $syohin_tenpo=select_syohin_tenpo($dbh,$syohin);
    $syohin_review=select_syohin_review($dbh,$syohin);
    $wanting_kazu=wanting_kazu($dbh,$syohin);
    $reprint_kazu=reprint_kazu($dbh,$syohin);
    $tenpo_new=tenpo_new($dbh,$tenpoCode);
    $genre_new=genre_new($dbh,$genreCode);

    session_start();
    if(!empty($_SESSION['puser'])){
        $puser=$_SESSION['puser'];
        $puserID=$puser['userId'];
    }
    
    //$genre=select_syohin_genre($dbh,$syohinId);
?>  



<!DOCTYPE html> 
<html lang="en-US"> 
<head> 
 	<meta charset="utf-8"> 
 	<title>商品詳細</title>
    <link rel="stylesheet" href="css/Product_detail.css">
    <script src="./jquery-3.6.0.min.js"></script>
    <!--<?php 
    //session_start();
    //if ($_SESSION['returnFLUG']==TRUE){
       // echo "<script> alert('レビューを送信しました。')</script>"
    //}?>-->
</head> 
<body style="background-color:#e0ccab;">
    <?php include 'header.php' ?>
    <?php if(isset($member)) : ?>
        <?php $userId=$member['userId'];?>
    <?php else: ?>
        <?php $userId=null;?>
    <?php endif; ?>
    <?php $user_reprint_list=user_reprint($dbh,$userId);?>
    <?php $user_wanting_list=user_wanting($dbh,$userId);?>
    <?php $user_bought_list=user_bought($dbh,$userId);?>
    <?php if ($syohin_genre['genreName'] === null){
        $syohinId['genreName'] = FALSE;
    }?>
    <?php $bought=false;?>
        <?php foreach($user_bought_list as $boughtlist):
            if($syohin==$boughtlist['syohinId']) {
                $bought=true;
                break;
            }
        endforeach;
    ?>
    
    <?php $bought=false;?>
        <?php foreach($user_bought_list as $boughtlist):
            if($syohin==$boughtlist['syohinId']) {
                $bought=true;
                break;
            }
        endforeach;
    ?>
    <div class="product_detail">
        <div class="product">
        <?php if(is_null($syohinId['photo'])||$syohinId['photo']==""){ ?>
            <!--画像がない時の画像を表示-->
            <img src="images/no_image.png ?>"width='240' height="240"/>
            <?php }else{ ?>
                <img src = "images/<?= $syohinId['photo']?>" width = '240' height = '240' />
            <?php } ?>
            <?php if($bought==true){?>
                <img src="images/Ribbon_bought_240_240.PNG"class="absolute"/>
            <?php }?>
        </div>
        <div class="detail">
            <a>商品名：</a><?=$syohinId['syohinName']?><br>
            <a>ジャンル：</a><?=$syohin_genre['genreName']?><br>
            <a>値段：</a><?=$syohinId['price']?><a>円</a><br>
            <a>販売店舗：</a><?=$syohin_tenpo['tenpoName']?><br>
            <a>販売期間：</a><?=$syohinId['startDate']?><a>~</a>
            <?php if ($syohinId['endDate']==null){?>
                <a>なくなり次第終了</a><br>
            <?php }?>
                <?=$syohinId['endDate']?>
        </div>
    </div>
    <div class="reprint">
        <div class="buttonall">
            <?php $reprint=false;?>
                <?php foreach($user_reprint_list as $reprintlist):#復刻リクエストされているか
                    if($syohin==$reprintlist['syohinId']) {
                        $reprint=true;
                        break;
                    }
                endforeach;
            ?>
            <?php if($userId!=null){#ログインしていると
                if ($reprint==true){?>
                    <input type="button" value="復刻リクエスト済" class="button"/><br>
                <?php }else{?>
                    <a href="reprintInsert_Product_detail.php?userId=<?=$userId?>&syohinId=<?=$syohin?>">
                    <input type="button" value="復刻リクエスト" class="button"/><br></a>
                <?php }?>
            <?php }else{?>
                <!--未ログイン　ログイン遷移-->
                <a href="login.php">
                <input type='submit' value='復刻リクエスト' class="button"/><br>
                </a>
            <?php }?>
            <a class="button_reprint"><?=$reprint_kazu['']?>人がリクエスト</a>
        </div>
        <div class="buttonall">
            <?php $wanting=false;
            foreach($user_wanting_list as $wantinglist):
                
                if($syohin==$wantinglist['syohinId']) {
                    $wanting=true;
                    break;
                }
            endforeach;?>
            <?php if($userId!=null){#ログインしていると
                if($wanting==true){#商品を欲しリスに入れている
                    ?>          
                    <!--ログイン時　欲しリス削除-->
                    <a href="wantingDelete_Product_detail.php?wantingId=<?=$wantinglist['wantingId']?>&syohinId=<?=$syohin?>"> 
                    <input type='button' value='ほしいものリストに追加済' class="button"/><br>
                    </a>
                    <?php
                }else{#欲しリスに入れていない
                    ?>          <!--ログイン時　欲しリス登録-->
                    <a href="wantingInsert_Product_detail.php?userId=<?=$userId?>&syohinId=<?=$syohin?>"> 
                    <input type='button' value='ほしいものリストに追加' class="button"/><br>
                    </a><?php
                }
            }else{?>
                <!--未ログイン　ログイン遷移-->
                <a href="login.php">
                <input type='submit' value='ほしいものリストに追加' class="button"/><br>
                </a>
                <?php
            }?>
            <a class="button_list"><?=$wanting_kazu['']?>人が追加</a>
        </div>
        <div class="buttonall">
            
            <?php if($userId!=null){#ログインしていると
                if ($bought==true){?>
                    <input type="button" value="購入済み" class="button"/><br>
                <?php }else{?>
                    <a href="boughtinset_Product_detail.php?userId=<?=$userId?>&syohinId=<?=$syohin?>">
                    <input type="button" value="購入済みリボンを付ける" class="button"/><br></a>
                <?php }?>
            <?php }else{?>
                <!--未ログイン　ログイン遷移-->
                <a href="login.php">
                <input type='submit' value='購入済みリボンを付ける' class="button"/><br>
                </a>
            <?php }?>
        </div>
    </div>
    <div class="explanation">
        <h1>商品の説明</h1>
        <p><?=$syohinId['explanation']?></p>
    </div>
    <!--<div class="allergy">
        <h1>アレルギー情報</h1>
    </div>-->
    <div class="connection_product">
        <h1>関連商品</h1>
        <div class="connection_product_2">
        <?php foreach($tenpo_new as $tenpo_new_a) : ?>
            <?php $tenpo_bought=false;?>
            <?php foreach($user_bought_list as $boughtlist):
                if($tenpo_new_a['syohinId']==$boughtlist['syohinId']) {
                    $tenpo_bought=true;
                    break;
                }
                
            endforeach;
        ?> 
        <?php if($tenpo_new_a['syohinId']!=$syohinId['syohinId']){ ?>
            <tr>
                <td>
                    <div class="connection_product_image">
                        <a href="Product_detail.php?syohinId=<?=$tenpo_new_a['syohinId']?>">
                        <div class="product">
                            <?php if(is_null($tenpo_new_a['photo'])||$tenpo_new_a['photo']==""){ ?>
                                <!--画像がない時の画像を表示-->
                                <img src="images/no_image.png ?>"width='240' height="240"/>
                            <?php }else{ ?>
                                <img src = "images/<?= $tenpo_new_a['photo']?>" width = '240' height = '240' />
                                <?php if($tenpo_bought==true){?>
                                    <img src="images/Ribbon_bought_240_240.PNG"class="absolute"/>
                                <?php }?>
                            <?php } ?>
                        </div>
                        </a>
                        <a>商品名：</a>
                        <?php #商品名
                            print mb_strimwidth( $tenpo_new_a['syohinName'] , 0, 20, '…', 'UTF-8' );#表示文字制限
                        ?><br>
                        <a>値段：<?=$tenpo_new_a['price']?>円</a><br>
                    </div>
                </td>
            </tr>
        <?php } ?>
        <?php endforeach ?>
        <?php foreach($genre_new as $genre_new_a) : ?>
            <?php $genre_bought=false;?>
            <?php foreach($user_bought_list as $boughtlist):
                if($genre_new_a['syohinId']==$boughtlist['syohinId']) {
                    $genre_bought=true;
                    break;
                }
                
            endforeach;
        ?>   
        <?php $genre_new_bought=false;?> 
        <?php foreach($tenpo_new as $tenpo_new_a) :
             if($genre_new_a['syohinId']==$tenpo_new_a['syohinId']){ 
                $genre_new_bought=true;
                
             } ?>
        <?php endforeach ?>
        <?php if($genre_new_a['syohinId']!=$syohinId['syohinId']){ ?>
            <?php if($genre_new_bought!=true){ ?>

            <tr>
                <td>
                    <div class="connection_product_image">
                        <a href="Product_detail.php?syohinId=<?=$genre_new_a['syohinId']?>">
                        <div class="product">
                            <?php if(is_null($genre_new_a['photo'])||$genre_new_a['photo']==""){ ?>
                                <!--画像がない時の画像を表示-->
                                <img src="images/no_image.png ?>"width='240' height="240"/>
                            <?php }else{ ?>
                                <img src = "images/<?= $genre_new_a['photo']?>" width = '240' height = '240' />
                                <?php if($genre_bought==true){?>
                                    <img src="images/Ribbon_bought_240_240.PNG" class="absolute"/>
                                <?php }?>
                            <?php } ?>
                        </div>
                        </a>
                        <a>商品名：</a>
                        <?php #商品名
                            print mb_strimwidth( $genre_new_a['syohinName'] , 0, 20, '…', 'UTF-8' );#表示文字制限
                        ?><br>
                        <a>値段：<?=$genre_new_a['price']?>円</a><br>
                    </div>
                </td>
            </tr>
            <?php } ?>
        <?php } ?>
        
        <?php endforeach ?>
        </div>
    </div>
    <div class="reviw">
        <h1>レビュー</h1>
        <?php $counts=0?>
        <?php $hyouka=0?>
        <?php if($syohin_review == null){ ?>
                <h2>平均評価：なし</h2>
            <?php }
             else{ ?>
                <?php foreach($syohin_review as $syohin_review_a) : ?>
                    
                    <tr>
                        <td>
                            <?php $counts++?>
                            <?php $hyouka=$hyouka+$syohin_review_a['evaluation']?>
                        </td>
                    </tr>
                <?php endforeach ?>
                <?php $heikin=$hyouka/$counts?>
                <a>平均評価：<?=$heikin?></a>
            <?php } ?>
        
        <div class="reviw_comment">
            <?php if($syohin_review == null){ ?>
                <h2>まだレビューが入っていません。</h2>
            <?php }
             else{ ?>
                <?php foreach($syohin_review as $syohin_review_a) : ?>
                    
                    <tr>
                        <td>
                            <div class="reviw_comments">
                                <a>評価：<?=$syohin_review_a['evaluation']?></a><br>
                                <a>コメント</a><br>
                                <a><?=$syohin_review_a['comment']?></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            <?php } ?>
        </div>
        <div>
            
            
        <?php if($userId!=null){#ログインしていると
            if($bought==true){
                $review=select_reviewID_flag($dbh,$puserID,$syohinId['syohinId']);
                            if(empty($review)){ ?>
                    <button class="review_go" onclick="location.href='review.php?syohinId=<?=$syohin?>'" ><h2>レビューする！　▷<h2></button>
                <?php  }else{?>
                    <button class="review_go" disabled><h2>レビューする！　▷<br>*すでにレビュー済みです<h2></button>
                <?php }?>

                
            <?php }else{?>
                <button class="review_go" disabled><h2>レビューする！　▷<br>*購入済みならレビューできます<h2></button>
            <?php }?>
        <?php }else{?>
            <!--未ログイン　ログイン遷移-->
            <button class="review_go" onclick="location.href='login.php'" ><h2>レビューする！　▷<h2></button>
            </a>
        <?php } ?>
        </div>
    </div>
</body>
</html>