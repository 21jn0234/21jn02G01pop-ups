<?php
#欲しリス削除
    require_once './helpers/db_helper.php';
        $dbh=get_db_connect();
        $wantingId=$_GET['reprintId'];
        
        
        $sql ="DELETE FROM reprint WHERE reprintId=:reprintId";
    
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':reprintId',$wantingId,PDO::PARAM_STR);
        
        $stmt->execute();
        header("Location:listall.php");
        //print($wantingId);

?>