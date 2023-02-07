<?php
#require_once './helpers/db_helper.php';
#$dbh=get_db_connect();

if(isset($_GET['sold_soltid'])!=""){
    $soldId=$_GET['sold_soltid'];
    if($soldId==1){
        $syohin_list=solt_syohin_new($dbh);
    }elseif($soldId==2){
        $syohin_list=solt_syohin_wanting($dbh);
    }elseif($soldId==3){
        $syohin_list=solt_syohin_cheap($dbh);
    }elseif($soldId==4){
        $syohin_list=solt_syohin_high($dbh);
    }elseif($soldId==5){
        $syohin_list=solt_syohin_review_count($dbh);  
    }elseif($soldId==6){
        $syohin_list=solt_syohin_review_evaluation($dbh);
    };
}else{
    $syohin_list=solt_syohin_new($dbh);
}
?>
<br>
</head> 
<body>
<?php
$sold_list_last=[]; #販売終了の商品を最終的に入れる2次元配列
$n=0;   #販売終了の商品の要素数
foreach($syohin_list as $sl):
    $today = date("Y-m-d");
    $getday=$sl['endDate']; #今日の日付と終了日の比較
    if($getday!=null&&$today>$getday){
        $sold_list=['syohinId'=>$sl['syohinId'],'syohinName'=>$sl['syohinName'],
                    'price'=>$sl['price'],'genreCode'=>$sl['genreCode'],'tenpoCode'=>$sl['tenpoCode'],
                    'startDate'=>$sl['startDate'],'endDate'=>$sl['endDate'],'photo'=>$sl['photo'],
                    'explanation'=>$sl['explanation']];#商品情報をlist配列に格納
                    
        $sold_list_last[$n]=$sold_list;#商品ごとの配列に格納
        $n++;
    };
endforeach;
$n=0;
?>
