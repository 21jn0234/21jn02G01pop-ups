<?php
#require_once './helpers/db_helper.php';
#$dbh=get_db_connect();

if(isset($_GET['sale_soltid'])!=""){
    $saleId=$_GET['sale_soltid'];
    if($saleId==1){#新着
        $syohin_list=solt_syohin_new($dbh);
    }elseif($saleId==2){#欲しリス
        $syohin_list=solt_syohin_wanting($dbh);
    }elseif($saleId==3){#安い順
        $syohin_list=solt_syohin_cheap($dbh);
    }elseif($saleId==4){#高い順
        $syohin_list=solt_syohin_high($dbh);
    }elseif($saleId==5){#レビュー数順
        $syohin_list=solt_syohin_review_count($dbh);  
    }elseif($saleId==6){#レビュー高評価
        $syohin_list=solt_syohin_review_evaluation($dbh);
    };
}else{
    $syohin_list=solt_syohin_new($dbh);
}



$sale_list_last=[]; #販売中の商品を最終的に入れる2次元配列

$i=0;   #販売中の商品の要素数


foreach($syohin_list as $sl):
    $today = date("Y-m-d");
    $getday=$sl['endDate']; #今日の日付と終了日の比較

    #販売中(nullまたは今日より終了日が先だったら）
    $sale_list=['syohinId'=>$sl['syohinId'],'syohinName'=>$sl['syohinName'],
                'price'=>$sl['price'],'genreCode'=>$sl['genreCode'],'tenpoCode'=>$sl['tenpoCode'],
                'startDate'=>$sl['startDate'],'endDate'=>$sl['endDate'],'photo'=>$sl['photo'],
                'explanation'=>$sl['explanation']]; #商品情報をlist配列に格納

    $sale_list_last[$i]=$sale_list; #商品ごとの配列に格納
    $i++;
    
endforeach;
$i=0;


#print_r($syohin_list);
#print_r($sale_list_last);
#print_r($sold_list_last);
?>


