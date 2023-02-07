<?php
require_once './helpers/db_helper.php';
$dbh=get_db_connect();
$syohin_list=select_syohin_all($dbh);
$sale_list_last=[]; #販売中の商品を最終的に入れる2次元配列
$sold_list_last=[]; #販売終了の商品を最終的に入れる2次元配列
$i=0;   #販売中の商品の要素数
$n=0;   #販売終了の商品の要素数

foreach($syohin_list as $sl):
    $today = date("Y-m-d");
    $getday=$sl['endDate']; #今日の日付と終了日の比較

    if($getday==null||$today<=$getday){ #販売中(nullまたは今日より終了日が先だったら）
        $sale_list=['syohinId'=>$sl['syohinId'],'syohinName'=>$sl['syohinName'],
                    'price'=>$sl['price'],'genreCode'=>$sl['genreCode'],'tenpoCode'=>$sl['tenpoCode'],
                    'startDate'=>$sl['startDate'],'endDate'=>$sl['endDate'],'photo'=>$sl['photo'],
                    'explanation'=>$sl['explanation']]; #商品情報をlist配列に格納

        $sale_list_last[$i]=$sale_list; #商品ごとの配列に格納
        $i++;
      
    }else{ #販売終了
        $sold_list=['syohinId'=>$sl['syohinId'],'syohinName'=>$sl['syohinName'],
                    'price'=>$sl['price'],'genreCode'=>$sl['genreCode'],'tenpoCode'=>$sl['tenpoCode'],
                    'startDate'=>$sl['startDate'],'endDate'=>$sl['endDate'],'photo'=>$sl['photo'],
                    'explanation'=>$sl['explanation']];#商品情報をlist配列に格納
                    
        $sold_list_last[$n]=$sold_list;#商品ごとの配列に格納
        $n++;
       
    };  
endforeach;
$i=0;
$n=0;


#print_r($syohin_list);
#print_r($sale_list_last);
#print_r($sold_list_last);
?>


