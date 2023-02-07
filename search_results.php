<!DOCTYPE html>
<html lang="Ja">
<head>
    <meta charset="utf-8">
    <link href="css/search_results.css" rel="stylesheet" />
    <title>検索結果一覧</title> 
    <!-- jQueryファイルの読み込み -->
    <script src="./jquery-3.6.0.min.js"></script>
    <body style="background-color:#e0ccab;">
    
</head>

<?php

    require_once 'helpers/db_helper.php';
    include "header.php";
    $dbh=get_db_connect();
    require 'search_sort_sale1.php';

    $sale=$sale_list_last;#販売中の2次元配列

    $syohinName='';
    $tenpoCode='';
    $genreCode='';
    $userId='';
    

    if(isset($member['userId'])){
        $userId=$member['userId'];

        #ユーザーの購入情報、復刻情報、レビュー情報、欲しリス情報取得
        $user_bought_list=user_bought($dbh,$userId);
        $user_reprint_list=user_reprint($dbh,$userId);
        $user_review_list=user_review($dbh,$userId);
        $user_wanting_list=user_wanting($dbh,$userId);

        //print_r($select_puser_all);
    }
    else{
        $userId=null;
        //print 'sgsfgsgs';
    }

    if(isset($_GET['keyword'])){
        $syohinName=$_GET['keyword'];
    }
    if(isset($_GET['tenpoCode'])){
        $tenpoCode=$_GET['tenpoCode'];
        $tenpo_list=select_tenpo_by_tenpocode($dbh,$tenpoCode);
        $tenpo=select_tenpo_db($dbh,$tenpoCode);
    }
    if(isset($_GET['genreCode'])){
        $genreCode=$_GET['genreCode'];
        $genre_list=select_genre_by_genrecode($dbh,$genreCode);
        $genre=select_genre_db($dbh,$genreCode);
    }
    
    
?>



<body>

<?php 
    foreach($sale as $sale):?> <!--販売されている商品のlistのforeach-->
    
        <?php
        $bought=false;
        $wanting=false;
        $review=false;
    if($userId!=""){
        #購入されている商品のリスト
        foreach($user_bought_list as $boughtlist):
            if($sale['syohinId']==$boughtlist['syohinId']) {
                $bought=true;
                break;
            }
        endforeach;

        #欲しリスに登録されている商品のリスト
        foreach($user_wanting_list as $wantinglist):
            if($sale['syohinId']==$wantinglist['syohinId']) {
                $wanting=true;
                break;
            }
        endforeach;

        #レビューされている商品のリスト
        foreach($user_review_list as $reviewlist):
            if($sale['syohinId']==$reviewlist['syohinId']) {
                $review=true;
                break;
            }
        endforeach;
    }
    endforeach;
    
    ?>

    <h1>商品名で探す</h1>

    <?php 
    $keyword='';
    if(isset($_GET['keyword'])){
        $keyword = $_GET['keyword'];
    }   ?>
    <form id="form1" action="">
            <input id="sbox" name="keyword" type="text" style="width: 420px; height: 50px;" value="<?= $keyword ?>" />
            <input id="sbtn" type="submit" style="width: 60px; height: 55px;" value="🔎"/>
    </form>
    <select name="select" onChange="location.href=value;">
        <option value="#">詳しい条件で探す</option>
        <option value="search_tenpo.php">お店から探す</option>
        <option value="search_genre.php">ジャンルから探す</option>
        <option value="search_results.php">商品名で探す</option>
    </select>
    

    <?php 
    if($keyword=="" && $tenpoCode=="" && $genreCode==""){ ?>
    
        <div class=title_sort>
            <div class="title">
                <h2>商品一覧</h2>
            </div>
            <div class="sort"> 
                <p>並び替え</p>
                <?php  require 'search_sort_sale2.php'?>
            </div>
        </div>
    <div class="syohin">
        <?php $search_syohin=$sale_list_last;#select_syohin_aiueo($dbh);
        foreach($search_syohin as $syohinName): ?>
            <?php
        $bought=false;
        $wanting=false;
        $review=false;
        if($userId!=""){
        #購入されている商品のリスト
        foreach($user_bought_list as $boughtlist):
            if($syohinName['syohinId']==$boughtlist['syohinId']) {
                $bought=true;
                break;
            }
        endforeach;

        #欲しリスに登録されている商品のリスト
        foreach($user_wanting_list as $wantinglist):
            if($syohinName['syohinId']==$wantinglist['syohinId']) {
                $wanting=true;
                break;
            }
        endforeach;
           
        #レビューされている商品のリスト
        foreach($user_review_list as $reviewlist):
            if($syohinName['syohinId']==$reviewlist['syohinId']) {
                $review=true;
                break;
            }
        endforeach;
    }
    ?>
    <div class="syohin_a">
        <table>
            <tr>
                <td>
                <a href="Product_detail.php?syohinId=<?= $syohinName['syohinId'] ?>">
                    <div class="relative">
                    <?php if($syohinName['photo']=="" || (is_null($syohinName['photo']))){ ?>
                        <img src="images/no_image.png"width='120' height="120"/><!-- noimageの画像 -->
                        <?php if($bought==true){ ?> <!--買われていたら-->
                            <div class="ribbon">
                                <img src="images/Ribbon_bought_120_120.PNG"/>
                            </div>
                        <?php } 
                    }
                    else{?>
                        <img src="images/<?php print $syohinName['photo'] ?>"width='120' height="120"/>
                        <?php if($bought==true){ ?> <!--買われていたら-->
                        
                            <div class="ribbon">
                                <img src="images/Ribbon_bought_120_120.PNG"/>
                            </div>
                        <?php } ?>
                    <?php }?>
                    </div>

                </td>
            <tr>
            </tr>
                <td>
                    <a href="Product_detail.php?syohinId=<?=$syohinName['syohinId']?>">
                        <?php print mb_strimwidth($syohinName['syohinName'], 0, 15, '…', 'UTF-8')?>
                    </a>
                </td>
            </tr>
            </tr>
                <td>
                    <?php if($bought==false and $review==false){ ?>
                    ¥<?php print $syohinName['price'];
                    if($userId!=""){
                                $syohinId=$syohinName['syohinId'];#欲しリス登録＆削除用
                                if($wanting==true){#商品を欲しリスに入れている
                    ?>          
                                    <!--ログイン時　欲しリス削除-->
                                    <a href="search_wanting_Delete.php?wantingId=<?=$wantinglist['wantingId']?>">
                                        <input type='button' value='❤'>
                                     </a>
                                    <?php
                                }else{#欲しリスに入れていない
                    ?>              <!--ログイン時　欲しリス登録-->
                                    <a href="search_wanting_Insert.php?userId=<?=$userId?>&syohinId=<?=$syohinId?>"> 
                                        <input type='button' value='💛' >
                                    </a><?php
                                }
                            }else{?>
                                <!--未ログイン　ログイン遷移-->
                                <a href="login.php">
                                    <input type='submit' value='💛'>
                                </a><?php
                            }
                        }elseif($bought==true and $review!=true){#商品が買われている
                    ?>  <a href="review.php?syohinId=<?=$syohinName['syohinId']?>">
                            <input type=submit value=レビューする>
                        </a>
                    <?php
                        }elseif($bought==true and $review==true){?>
                            <input type=submit value=レビュー済み disabled><?php
                        };
                    ?>
                </td>
            </tr>
        </table>
        </div>
    <?php endforeach; ?>

    <?php }?>
</div>
    
    <!--検索結果からの商品表示-->
    <?php if(isset($_GET['keyword'])){ 
        if($keyword!=""){ 
            $search_syohin=select_syohin_search($dbh,$syohinName); 
    ?>
            
            <h2>検索結果</h2>
            <?php foreach($search_syohin as $syohinName): 
                if($search_syohin!=Array ( )) {
                    $bought=false;
                    $wanting=false;
                    $review=false;
                    if($userId!=""){
                        #購入されている商品のリスト
                        foreach($user_bought_list as $boughtlist):
                            if($syohinName['syohinId']==$boughtlist['syohinId']) {
                                $bought=true;
                                break;
                            }
                        endforeach;
                
                        #欲しリスに登録されている商品のリスト
                        foreach($user_wanting_list as $wantinglist):
                            if($syohinName['syohinId']==$wantinglist['syohinId']) {
                                $wanting=true;
                                break;
                            }
                        endforeach;
                
                        #レビューされている商品のリスト
                        foreach($user_review_list as $reviewlist):
                            if($syohinName['syohinId']==$reviewlist['syohinId']) {
                                $review=true;
                                break;
                            }
                        endforeach;
                    } ?>
                <div class="syohin_a">
                <table>
                    <tr>
                        <td>
                        <a href="Product_detail.php?syohinId=<?= $syohinName['syohinId'] ?>">
                            <div class="relative">
                            <?php 
                            if($syohinName['photo']=="" || is_null($syohinName['photo'])){ ?>
                                <img src="images/no_image.png"width='120' height="120"/><!-- noimageの画像 -->
                                <?php if($bought==true){ ?> <!--買われていたら-->
                                    <div class="ribbon">
                                        <img src="images/Ribbon_bought_120_120.PNG"/>
                                    </div>
                                <?php } 
                            }
                            else{?>
                                <img src="images/<?php print $syohinName['photo'] ?>"width='120' height="120"/>
                                <?php if($bought==true){ ?> <!--買われていたら-->
                                
                                    <div class="ribbon">
                                        <img src="images/Ribbon_bought_120_120.PNG"/>
                                    </div>
                                <?php } 
                            }?>
                            </div>

                        </td>
                    </tr>
                    <tr>
                    
                        <td>
                            <a href="Product_detail.php?syohinId=<?=$syohinName['syohinId']?>">
                                <?php print mb_strimwidth($syohinName['syohinName'], 0, 15, '…', 'UTF-8' )?>
                            </a>
                        </td>
                    </tr>
                        <td>
                        <?php if($bought==false and $review==false){ ?>
                        ¥<?php print $syohinName['price'];
                        if($userId!=""){
                                    $syohinId=$syohinName['syohinId'];#欲しリス登録＆削除用
                                    if($wanting==true){#商品を欲しリスに入れている
                        ?>          
                                        <!--ログイン時　欲しリス削除-->
                                        <a href="search_wanting_Delete.php?wantingId=<?=$wantinglist['wantingId']?>&keyword=<?=$keyword?>">
                                            <input type='button' value='❤'>
                                        </a>
                                        <?php
                                    }else{#欲しリスに入れていない
                        ?>              <!--ログイン時　欲しリス登録-->
                                        <a href="search_wanting_Insert.php?userId=<?=$userId?>&syohinId=<?=$syohinId?>&keyword=<?=$keyword?>"> 
                                            <input type='button' value='💛' >
                                        </a><?php
                                    }
                                }else{?>
                                    <!--未ログイン　ログイン遷移-->
                                    <a href="login.php">
                                        <input type='submit' value='💛'>
                                    </a><?php
                                }
                            }elseif($bought==true and $review!=true){#商品が買われている
                        ?>  <a href="review.php?syohinId=<?=$sale['syohinId']?>">
                                <input type=submit value=レビューする>
                            </a>
                        <?php
                            }elseif($bought==true and $review==true){?>
                                <input type=submit value=レビュー済み disabled><?php
                            };
                    ?>
                        </td>
                    </tr>
                </table>
                </div>
            <?php  }
           
            
            endforeach; ?>
            
        <?php } 
        if($search_syohin==Array ( )) { ?>
            <p>該当する商品はありません。</p>
        <?php }
    } ?>
    <!--店舗からの商品表示-->
    <?php if(isset($_GET['tenpoCode'])){ ?>
    <?php if($tenpo!=""){ ?>
        <h2>"<?= $tenpo['tenpoName'] ?>"の商品</h2>
    <?php } ?>
        <!--  <div class="title2">
        <h3>並び順<?php  //require 'listsolt_sale_search_results.php'?><--並び順></h3>
        </div> -->

        <?php foreach($tenpo_list as $tenpoCode): 
            $bought=false;
            $wanting=false;
            $review=false;
            if($userId!=""){
                #購入されている商品のリスト
                foreach($user_bought_list as $boughtlist):
                    if($tenpoCode['syohinId']==$boughtlist['syohinId']) {
                        $bought=true;
                        break;
                    }
                endforeach;
        
                #欲しリスに登録されている商品のリスト
                foreach($user_wanting_list as $wantinglist):
                    if($tenpoCode['syohinId']==$wantinglist['syohinId']) {
                        $wanting=true;
                        break;
                    }
                endforeach;
        
                #レビューされている商品のリスト
                foreach($user_review_list as $reviewlist):
                    if($tenpoCode['syohinId']==$reviewlist['syohinId']) {
                        $review=true;
                        break;
                    }
                endforeach;
            } ?>
            <div class="syohin_a">
            <table>
                <tr>
                    <td>
                    <a href="Product_detail.php?syohinId=<?= $tenpoCode['syohinId'] ?>">                           
                    <div class="relative">
                            <?php
                            if($tenpoCode['photo']=="" || is_null($tenpoCode['photo'])){ ?>
                                <img src="images/no_image.png"width='120' height="120"/><!-- noimageの画像 -->
                                <?php if($bought==true){ ?> <!--買われていたら-->
                                    <div class="ribbon">
                                        <img src="images/Ribbon_bought_120_120.PNG"/>
                                    </div>
                                <?php } 
                            }
                            else{?>
                            <img src="images/<?php print $tenpoCode['photo'] ?>"width='120' height="120"/>
                                <?php if($bought==true){ ?> <!--買われていたら-->
                                
                                    <div class="ribbon">
                                        <img src="images/Ribbon_bought_120_120.PNG"/>
                                    </div>
                                <?php } 
                            }?>
                            </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="Product_detail.php?syohinId=<?=$tenpoCode['syohinId']?>">
                            <?php print mb_strimwidth($tenpoCode['syohinName'], 0, 15, '…', 'UTF-8' )?>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                    <?php if($bought==false and $review==false){ ?>
                        ¥<?php print $tenpoCode['price'];
                        if($userId!=""){
                            $syohinId=$tenpoCode['syohinId'];#欲しリス登録＆削除用
                            if($wanting==true){#商品を欲しリスに入れている
                ?>          
                                <!--ログイン時　欲しリス削除-->
                                <a href="search_wanting_Delete.php?wantingId=<?=$wantinglist['wantingId']?>&tenpoCode=<?=$tenpoCode['tenpoCode']?>">
                                    <input type='button' value='❤'>
                                </a>
                                <?php
                            }else{#欲しリスに入れていない
                ?>              <!--ログイン時　欲しリス登録-->
                                <a href="search_wanting_Insert.php?userId=<?=$userId?>&syohinId=<?=$syohinId?>&tenpoCode=<?=$tenpoCode['tenpoCode']?>"> 
                                    <input type='button' value='💛' >
                                </a><?php
                            }
                        }else{?>
                            <!--未ログイン　ログイン遷移-->
                            <a href="login.php">
                                <input type='submit' value='💛'>
                            </a><?php
                        }
                    }elseif($bought==true and $review!=true){#商品が買われている
                ?>  <a href="review.php?syohinId=<?=$sale['syohinId']?>">
                        <input type=submit value=レビューする>
                    </a>
                <?php
                    }elseif($bought==true and $review==true){?>
                        <input type=submit value=レビュー済み disabled><?php
                    };
            ?>

                    </td>
                </tr>
            </table>
            </div>
        <?php endforeach?>
    <?php } ?>
    <!--ジャンルからの商品表示-->
    <?php if(isset($_GET['genreCode'])){ ?>
    <?php if($genre!=""){ ?>
        <h2>"<?= $genre['genreName'] ?>"の商品</h2>
    <?php } 
        foreach($genre_list as $genreCode): 
            $bought=false;
            $wanting=false;
            $review=false;
            if($userId!=""){
                #購入されている商品のリスト
                foreach($user_bought_list as $boughtlist):
                    if($genreCode['syohinId']==$boughtlist['syohinId']) {
                        $bought=true;
                        break;
                    }
                endforeach;
        
                #欲しリスに登録されている商品のリスト
                foreach($user_wanting_list as $wantinglist):
                    if($genreCode['syohinId']==$wantinglist['syohinId']) {
                        $wanting=true;
                        break;
                    }
                endforeach;
        
                #レビューされている商品のリスト
                foreach($user_review_list as $reviewlist):
                    if($genreCode['syohinId']==$reviewlist['syohinId']) {
                        $review=true;
                        break;
                    }
                endforeach;
            } ?>
            <div class="syohin_a">
            <table>
                <tr>
                    <td>
                    <a href="Product_detail.php?syohinId=<?= $genreCode['syohinId'] ?>">
                    <div class="relative">
                            <?php
                            if($genreCode['photo']=="" || is_null($genreCode['photo'])){ ?>
                                <img src="images/no_image.png"width='120' height="120"/><!-- noimageの画像 -->
                                <?php if($bought==true){ ?> <!--買われていたら-->
                                    <div class="ribbon">
                                        <img src="images/Ribbon_bought_120_120.PNG"/>
                                    </div>
                                <?php } 
                            }
                            else{?>
                                <img src="images/<?php print $genreCode['photo'] ?>"width='120' height="120"/>
                                <?php if($bought==true){ ?> <!--買われていたら-->
                                
                                    <div class="ribbon">
                                        <img src="images/Ribbon_bought_120_120.PNG"/>
                                    </div>
                                <?php } 
                            }?>
                            </div>
                    </td>
                </tr>
                <tr> 
                    <td>
                    <a href="Product_detail.php?syohinId=<?= $genreCode['syohinId'] ?>">
                        <?= mb_strimwidth($genreCode['syohinName'] , 0, 15, '…', 'UTF-8' )?></a>
                    </td>
                </tr>
                <tr>
                        <td>
                            <?php if($bought==false and $review==false){ ?>
                            ¥<?php print $genreCode['price'];
                            if($userId!=""){
                            $syohinId=$genreCode['syohinId'];#欲しリス登録＆削除用
                            if($wanting==true){#商品を欲しリスに入れている
                ?>          
                                <!--ログイン時　欲しリス削除-->
                                <a href="search_wanting_Delete.php?wantingId=<?=$wantinglist['wantingId']?>&genreCode=<?=$genreCode['genreCode']?>">
                                    <input type='button' value='❤'>
                                </a>
                                <?php
                            }else{#欲しリスに入れていない
                ?>              <!--ログイン時　欲しリス登録-->
                                <a href="search_wanting_Insert.php?userId=<?=$userId?>&syohinId=<?=$syohinId?>&genreCode=<?=$genreCode['genreCode']?>"> 
                                    <input type='button' value='💛' >
                                </a><?php
                            }
                        }else{?>
                            <!--未ログイン　ログイン遷移-->
                            <a href="login.php">
                                <input type='submit' value='💛'>
                            </a><?php
                        }
                    }elseif($bought==true and $review!=true){#商品が買われている
                ?>  <a href="review.php?syohinId=<?=$sale['syohinId']?>">
                        <input type=submit value=レビューする>
                    </a>
                <?php
                    }elseif($bought==true and $review==true){?>
                        <input type=submit value=レビュー済み disabled><?php
                    };
            ?>
                        </td>
                </tr>
            </table>
            </div>
        <?php endforeach?>
    <?php } ?>

</body>
</html>