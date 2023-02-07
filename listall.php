<!DOCTYPE html> 
<html> 
<head> 
 	<meta charset="utf-8"> 
 	<title>全体商品一覧</title>
    <link href="css/slick-theme.css" rel="stylesheet" type="text/css">
    <link href="css/slick.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/slick.css"/>
    <link href="css/listall.css" rel="stylesheet"/>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <body style="background-color:#e0ccab;">
    <?php 
    
        $soltid=0;
       
        require_once 'header.php';
        require_once './helpers/db_helper.php';
        $dbh=get_db_connect();
        require 'list_sort_sale1.php';
        require 'list_sort_sold1.php';

        $sale=$sale_list_last;#販売中の2次元配列
        $sold=$sold_list_last;#販売終了の2次元配列
       
        
        if(isset($member['userId'])){
            $userId=$member['userId'];
        }else{
            $userId=null;
        }
        #ユーザーの購入情報、復刻情報、レビュー情報、欲しリス情報取得
        $user_bought_list=user_bought($dbh,$userId);
        $user_reprint_list=user_reprint($dbh,$userId);
        $user_review_list=user_review($dbh,$userId);
        $user_wanting_list=user_wanting($dbh,$userId);

        #テスト用
        #print_r($user_bought_list); 
        // print_r($user_reprint_list);
        //print_r($user_review_list);
        // print_r($user_wanting_list);
        #print_r($sale);
        #print_r($sold);
                          
    ?>
    
    <br>
</head> 
<body>
    <div class="title_sort">
        <div class="title">
            <h2>販売中の商品</h2>
        </div> 

        <div class="sort"> 
            <h3>並び順</h3>
            <?php  require 'list_sort_sale2.php'?><!--並び順-->
        </div>
    </div>
    <div class='slider'>
    <!-- <div id="salesyohin">使ってない -->
    
    <?php 
    foreach($sale as $sale):?> <!--販売されている商品のlistのforeach-->
    
        <?php
        $bought=false;
        $wanting=false;
        $review=false;
    
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

    ?>
        <div class="syohin_a">
    
        <table align="center">
            <tr>
                <td>
                    <a href="Product_detail.php?syohinId=<?=$sale['syohinId']?>">
                        <!--商品画像-->
                       
                        <?php if($sale['photo']=="" || is_null($sale['photo'])){?> 
                            <img src="images/no_image.png"width='120' height="120"/><!-- noimageの画像 -->
                        <?php
                        }else{?>
                            <div class="relative">
                        <?php if($bought==true){ #買われていたら?>
                            <!--フラグを付ける（ｃｓｓ）-->
                            <img src="images/<?php print $sale['photo'] ?>"width='120' height="120"/>
                            <div class="ribbon">
                                <img src="images/Ribbon_bought_120_120.PNG"/>
                            </div>
                           
                         <?php }else{#買われていなかったら?> 
                                <img src="images/<?php print $sale['photo'] ?>"width='120' height="120"/>
                      <?php } ?>
                    <?php }?>
                            </div>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="Product_detail.php?syohinId=<?=$sale['syohinId']?>">
                        <?php #商品名
                            print mb_strimwidth( $sale['syohinName'] , 0, 15, '…', 'UTF-8' );#表示文字制限
                        ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td>
                    <?php #商品情報（商品名の下にあるやつ）
                        $num=$sale['price'];
                        if($bought==false and $review==false){#商品が買われていない
                    ?>￥<?php
                            print number_format($num);#値段
                            if($userId!=null){#ログインしてないと
                                $syohinId=$sale['syohinId'];#欲しリス登録＆削除用
                                if($wanting==true){#商品を欲しリスに入れている
                    ?>          
                                    <!--ログイン時　欲しリス削除-->
                                    <a href="wanting_Delete.php?wantingId=<?=$wantinglist['wantingId']?>">
                                        <input type='button' value='❤'>
                                     </a>
                                    <?php
                                }else{#欲しリスに入れていない
                    ?>              <!--ログイン時　欲しリス登録-->
                                    <a href="wanting_Insert.php?userId=<?=$userId?>&syohinId=<?=$syohinId?>"> 
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
    <!-- </div> -->
    <?php 
        endforeach; 
        
    ?>
    </div>


    <!-------------------------------------------------------------------------------------------------------------->
    <div class="title_sort">
    <div class="title">
        <h2 >販売終了</h2>
    </div>
    <div class="sort"> 
        <h3>並び順</h3>
        <?php require 'list_sort_sold2.php';?>
    </div>
    </div> 
    <div class='slider'>
        <?php foreach($sold as $sold):?>
            
            <div class="syohin_a">
                <?php
                $reprint=false;
                $bought=false;
                
                foreach($user_reprint_list as $reprintlist):#復刻リクエストされているか
                    if($sold['syohinId']==$reprintlist['syohinId']) {
                        $reprint=true;
                        break;
                    }
                endforeach;

                foreach($user_bought_list as $boughtlist):#商品が買われていたか
                    if($sold['syohinId']==$boughtlist['syohinId']) {
                        $bought=true;
                        break;
                    }
                endforeach;?> 
        
                    <table align="center">
                        <tr>
                            <td><!--商品画像-->
                                <a href="Product_detail.php?syohinId=<?=$sold['syohinId']?>">
                                <?php 
                                    if($sold['photo']=="" || is_null($sold['photo'])){ ?>
                                        <img src="images/no_image.png"width='120' height="120"/><!-- noimageの画像 -->
                                <?php }else{  
                                        if($bought==true){ #買われていたら?>
                                        <div class="relative">
                                            <img src="images/<?php print $sold['photo'] ?>"width='120' height="120"/>
                                            <div class="ribbon">
                                                <img src="images/Ribbon_bought_120_120.PNG"/>
                                            </div>
                                <?php
                                        }else{#買われていなかったら?> 
                                            <img src="images/<?php print $sold['photo'] ?>"width='120' height="120"/>
                                <?php  }?>
                                <?php } ?>
                                    </div>
                                </a>
                
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!--商品名-->
                                <a href="Product_detail.php?syohinId=<?=$sold['syohinId']?>">
                                    <?php print mb_strimwidth( $sold['syohinName'] , 0, 15, '…', 'UTF-8' )#表示文字制限?>
                                </a>
                            </td>
                        </tr>
            
                        <tr>
                            <td><!--商品情報-->
                                <?php
                                if($userId!=null){#ログインしてないと
                                    $syohinId=$sold['syohinId'];#欲しリス登録＆削除用
                                    if($reprint==true){ #復刻リクエスト登録済み?>
                                        <!-- <a href="reprintDelete.php?reprintId=<?=$reprintlist['reprintId']?>">  -->
                                        <input type='submit' value="復刻リクエスト済み" disabled></br>
                                        <!-- </a> -->
                                        <?php 
                                    }elseif($reprint==false){#復刻リクエスト未登録?>
                                        <a href="reprint_Insert.php?userId=<?=$userId?>&syohinId=<?=$syohinId?>"> 
                                        <input type='submit' value="復刻リクエスト"></br></a>
                                    <?php }
                                    }else{?>
                                    <!--未ログイン　ログイン遷移-->
                                    <a href="login.php">
                                    <input type='submit' value="復刻リクエスト"></br>
                                    </a>
                                <?php }?> 
                            </td>
                        </tr>
                    </table>
            </div>
    
            <?php endforeach;?>
    </div>
    
<script type="text/javascript" src="dist/js/slick.min.js"></script>
<!-- <script type="text/javascript" src="dist/js/slick.js"></script> -->
<script type="text/javascript" src="dist/js/listall.js"></script>

</body>