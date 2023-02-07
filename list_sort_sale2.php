<!--使いまわし方
ソート機能を使うなら'listsolt_sale.php'（どの並び順かを指定する）と
'list_sale_solt.php'（指定された並び順で商品情報を出力）を使う
-->
<?php
        
   if(isset($_GET['sale_soltid'])!=""){         
        $saleId=$_GET['sale_soltid'];
        if($saleId==1){
        ?>
                <select onChange="location.href=value;">
                        <option value = "listall.php?sale_soltid=<?=1?>" selected>新着順</option>
                        <option value = "listall.php?sale_soltid=<?=2?>">欲しリス数順</option>
                        <option value = "listall.php?sale_soltid=<?=3?>">価格(安い順)</option>
                        <option value = "listall.php?sale_soltid=<?=4?>">価格(高い順)</option>
                        <option value = "listall.php?sale_soltid=<?=5?>">レビュー数順</option>
                        <option value = "listall.php?sale_soltid=<?=6?>">レビュー高評価順</option>
                </select>
        <?php
        }elseif($saleId==2){
        ?>
                <select onChange="location.href=value;">
                        <option value = "listall.php?sale_soltid=<?=1?>">新着順</option>
                        <option value = "listall.php?sale_soltid=<?=2?>" selected>欲しリス数順</option>
                        <option value = "listall.php?sale_soltid=<?=3?>">価格(安い順)</option>
                        <option value = "listall.php?sale_soltid=<?=4?>">価格(高い順)</option>
                        <option value = "listall.php?sale_soltid=<?=5?>">レビュー数順</option>
                        <option value = "listall.php?sale_soltid=<?=6?>">レビュー高評価順</option>
                </select>
        <?php
        }elseif($saleId==3){
        ?>
                <select onChange="location.href=value;">
                        <option value = "listall.php?sale_soltid=<?=1?>">新着順</option>
                        <option value = "listall.php?sale_soltid=<?=2?>">欲しリス数順</option>
                        <option value = "listall.php?sale_soltid=<?=3?>" selected>価格(安い順)</option>
                        <option value = "listall.php?sale_soltid=<?=4?>">価格(高い順)</option>
                        <option value = "listall.php?sale_soltid=<?=5?>">レビュー数順</option>
                        <option value = "listall.php?sale_soltid=<?=6?>">レビュー高評価順</option>
                </select>
        <?php
        }elseif($saleId==4){
        ?>
                <select onChange="location.href=value;">
                        <option value = "listall.php?sale_soltid=<?=1?>">新着順</option>
                        <option value = "listall.php?sale_soltid=<?=2?>">欲しリス数順</option>
                        <option value = "listall.php?sale_soltid=<?=3?>">価格(安い順)</option>
                        <option value = "listall.php?sale_soltid=<?=4?>" selected>価格(高い順)</option>
                        <option value = "listall.php?sale_soltid=<?=5?>">レビュー数順</option>
                        <option value = "listall.php?sale_soltid=<?=6?>">レビュー高評価順</option>
                </select>
        <?php
        }elseif($saleId==5){
        ?>
                <select onChange="location.href=value;">
                        <option value = "listall.php?sale_soltid=<?=1?>">新着順</option>
                        <option value = "listall.php?sale_soltid=<?=2?>">欲しリス数順</option>
                        <option value = "listall.php?sale_soltid=<?=3?>">価格(安い順)</option>
                        <option value = "listall.php?sale_soltid=<?=4?>">価格(高い順)</option>
                        <option value = "listall.php?sale_soltid=<?=5?>" selected>レビュー数順</option>
                        <option value = "listall.php?sale_soltid=<?=6?>">レビュー高評価順</option>
                </select>
        <?php
        }elseif($saleId==6){
        ?>
                <select onChange="location.href=value;">
                        <option value = "listall.php?sale_soltid=<?=1?>">新着順</option>
                        <option value = "listall.php?sale_soltid=<?=2?>">欲しリス数順</option>
                        <option value = "listall.php?sale_soltid=<?=3?>">価格(安い順)</option>
                        <option value = "listall.php?sale_soltid=<?=4?>">価格(高い順)</option>
                        <option value = "listall.php?sale_soltid=<?=5?>">レビュー数順</option>
                        <option value = "listall.php?sale_soltid=<?=6?>" selected>レビュー高評価順</option>
                </select>
        <?php
        };
    }else{
        ?>
                <select onChange="location.href=value;">
                        <option value = "listall.php?sale_soltid=<?=1?>" selected>新着順</option>
                        <option value = "listall.php?sale_soltid=<?=2?>">欲しリス数順</option>
                        <option value = "listall.php?sale_soltid=<?=3?>">価格(安い順)</option>
                        <option value = "listall.php?sale_soltid=<?=4?>">価格(高い順)</option>
                        <option value = "listall.php?sale_soltid=<?=5?>">レビュー数順</option>
                        <option value = "listall.php?sale_soltid=<?=6?>">レビュー高評価順</option>
                </select>
        <?php
    }
?>
    
