<?php
    require_once './helpers/db_helper.php';
    $dbh = get_db_connect();
    $ranking = ranking_get($dbh);
    $ranking4 = ranking_get_4($dbh);

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
    
    <html>
    <link rel = "stylesheet" href = "css/ranking.css">
    <script src="./jquery-3.6.0.min.js"></script>
    <head>
    
        <meta charset="utf-8">
        <title>ランキング</title>
       
    </head>
        
    <body style="background-color:#e0ccab;">
        <?php include 'header.php' ?>
    
    
    
    <?php $cnt = 1?>
    <div class = "ran">
    <?php foreach($ranking as $ran) : ?>
        <?php if($cnt == 1 || $cnt == 2 || $cnt == 3){?>
            <div class="ran_syohin_a">
        <table>
             <?php if($cnt == 1){?>
             <tr>
                 <td>
                 <img src="images/ranking_1.PNG"width='50' height="50"/>
                </td>
            </tr>
            <?php }else if($cnt == 2){?>
             <tr>
                 <td>
                 <img src="images/ranking_2.PNG"width='50' height="50"/>
                </td>
            </tr>
            <?php }else if($cnt == 3){?>
             <tr>
                 <td>
                 <img src="images/ranking_3.PNG"width='50' height="50"/>
                </td>
            </tr>
            <?php } else{?>
                <tr>
                    <td width='56' height="56"><?= $cnt?>位</td>
                </tr>
            <?php } ?> 
        <tr>
            <td>
            <a href = "Product_detail.php?syohinId=<?=$ran['syohinId']?>">
            <?php if(is_null($ran['photo'])){ ?>      
            <!--画像がない時の画像を表示-->
                <div class="relative_a">    
                    <img src="images/no_image.png ?>"width='240' height="240"/>
                    <?php if(!is_null($puserID)){ ?>
        
            <?php $ranhandan = ranking_bought($dbh,$puserID)?>
        <?php foreach($ranhandan as $ranhan) : ?>
            <?php if($ran['syohinId'] == $ranhan['syohinId']){ ?>
                   
                            <div class="ribbon">
                                <img src="images/Ribbon_bought_240_240.PNG"/>
                            </div>
                    
                   
                <?php }?>
           
        <?php endforeach ?>
        <?php }?>
                </div>
                <?php }else{ ?>
                <div class="relative_a"> 
                    <img src = "images/<?= $ran['photo'] ?>" width = '240' height = '240'/>
                    <?php if(!is_null($puserID)){ ?>
        
        <?php $ranhandan = ranking_bought($dbh,$puserID)?>
            <?php foreach($ranhandan as $ranhan) : ?>
            <?php if($ran['syohinId'] == $ranhan['syohinId']){ ?>
               
                        <div class="ribbon">
                            <img src="images/Ribbon_bought_240_240.PNG"/>
                        </div>
                
               
            <?php }?>
            <?php endforeach ?>
        <?php }?>
                </div>
        <?php } ?>
        </a>
            </td>
        </tr>
        <tr>
            <td class = "max_25ch">
            <a href = "Product_detail.php?syohinId=<?=$ran['syohinId']?>">商品名：<?= $ran['syohinName'] ?>
            </td>
        </tr>
        <tr>
            <td>
                平均評価　<?= $ran['eva'] ?>
            </td>
        </tr>
    
        </table>
            </div>
    
    <?php } ?>
    <?php $cnt += 1?>
    <?php endforeach ?>
    </div>
    <?php $cnt4 = 4?>
    <div class ="ran4">
    <?php foreach($ranking4 as $ran4) : ?>
        <table class ="ran4_syohin">
             <?php if($cnt4 == 1){?>
             <tr>
                 <td>
                 <img src="images/ranking_1.png ?>"width='50' height="50"/>
                </td>
            </tr>
            <?php }else if($cnt4 == 2){?>
             <tr>
                 <td>
                 <img src="images/ranking_2.png ?>"width='50' height="50"/>
                </td>
            </tr>
            <?php }else if($cnt4 == 3){?>
             <tr>
                 <td>
                 <img src="images/ranking_3.png ?>"width='50' height="50"/>
                </td>
            </tr>
            <?php } else{?>
                <tr>
                    <td width='56' height="56"><?= $cnt4?>位</td>
                </tr>
            <?php } ?> 
        <tr>
            <td>
            <a href = "Product_detail.php?syohinId=<?=$ran4['syohinId']?>">
            <?php if(is_null($ran4['photo'])){ ?>      
            <!--画像がない時の画像を表示-->
                <div class="relative">    
                    <img src="images/no_image.png ?>"width='120' height="120"/>
                    <?php if(!is_null($puserID)){ ?>
        
            <?php $ranhandan = ranking_bought($dbh,$puserID)?>
        <?php foreach($ranhandan as $ranhan) : ?>
            <?php if($ran['syohinId'] == $ranhan['syohinId']){ ?>
                   
                            <div class="ribbon">
                                <img src="images/Ribbon_bought_120_120.PNG"/>
                            </div>
                    
                   
                <?php }?>
           
        <?php endforeach ?>
        <?php }?>
                </div>
                <?php }else{ ?>
                <div class="relative"> 
                    <img src = "images/<?= $ran4['photo'] ?>" width = '120' height = '120'/>
                    <?php if(!is_null($puserID)){ ?>
        
        <?php $ranhandan = ranking_bought($dbh,$puserID)?>
            <?php foreach($ranhandan as $ranhan) : ?>
            <?php if($ran4['syohinId'] == $ranhan['syohinId']){ ?>
               
                        <div class="ribbon">
                            <img src="images/Ribbon_bought_120_120.PNG"/>
                        </div>
                
               
            <?php }?>
            <?php endforeach ?>
        <?php }?>
                </div>
        <?php } ?>
        </a>
            </td>
        </tr>
        <tr>
            <td class = "max_18ch">
            <a href = "Product_detail.php?syohinId=<?=$ran4['syohinId']?>">商品名：<?= $ran4['syohinName'] ?>
            </td>
        </tr>
        <tr>
            <td>
                平均評価　<?= $ran4['eva'] ?>
            </td>
        </tr>
        </table>
     
    
    <?php $cnt4 += 1?>
    <?php endforeach ?>
    </div>
                

    
</body>
</html>