<?php
#欲しリス登録
    require_once './helpers/db_helper_baba.php';
        $dbh=get_db_connect();
        $userId=$_GET['userId'];
        $syohinId=$_GET['syohinId'];
        $wantingId=wanting_numbering($dbh);
        
        $sql ="INSERT INTO wanting VALUES(:wantingId,:userId,:syohinId)";#inset into
    
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':wantingId',$wantingId,PDO::PARAM_STR);
        $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
        $stmt->bindValue(':syohinId',$syohinId,PDO::PARAM_STR);
        
        $stmt->execute();
        header("Location:Product_detail.php?syohinId=".$syohinId);

?>