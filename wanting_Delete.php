<?php
#欲しリス削除
    require_once './helpers/db_helper.php';
        $dbh=get_db_connect();
        $wantingId=$_GET['wantingId'];
        
        
        $sql ="DELETE FROM wanting WHERE wantingId=:wantingId";
    
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':wantingId',$wantingId,PDO::PARAM_STR);
        
        $stmt->execute();
        header("Location:listall.php");
        //print($wantingId);

?>