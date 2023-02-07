<?php
#欲しリス登録
    require_once './helpers/db_helper_baba.php';
        $dbh=get_db_connect();
        $userId=$_GET['userId'];
        $syohinId=$_GET['syohinId'];
        $reprintId=reprint_numbering($dbh);
        
        $sql ="INSERT INTO reprint VALUES(:reprintId,:syohinId,:userId)";#inset into
    
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':reprintId',$reprintId,PDO::PARAM_STR);
        $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
        $stmt->bindValue(':syohinId',$syohinId,PDO::PARAM_STR);
        
        $stmt->execute();
        header("Location:product_detail.php?syohinId=".$syohinId);

?>