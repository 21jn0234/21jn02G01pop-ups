<?php
#欲しリス登録
    require_once './helpers/db_helper.php';
        $dbh=get_db_connect();
        $userId=$_GET['userId'];
        $syohinId=$_GET['syohinId'];
        $buyId=bought_numbering($dbh);
        
        $sql ="INSERT INTO bought VALUES(:buyId,:userId,:syohinId)";#inset into
    
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':buyId',$buyId,PDO::PARAM_STR);
        $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
        $stmt->bindValue(':syohinId',$syohinId,PDO::PARAM_STR);
        
        $stmt->execute();
        header("Location:product_detail.php?syohinId=".$syohinId);

?>