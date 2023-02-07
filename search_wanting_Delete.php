<?php
#欲しリス削除
    require_once './helpers/db_helper.php';
        $dbh=get_db_connect();
        $wantingId=$_GET['wantingId'];
        $keyword=$_GET['keyword'];
        $tenpoCode=$_GET['tenpoCode'];
        $genreCode=$_GET['genreCode'];
        
        
        $sql ="DELETE FROM wanting WHERE wantingId=:wantingId";
    
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':wantingId',$wantingId,PDO::PARAM_STR);
        
        $stmt->execute();
        header("Location:search_results.php");
        //print($wantingId);

        if($keyword!=""){
            header("Location:search_results.php?keyword=".$keyword);
        }
        elseif($tenpoCode!=""){
            header("Location:search_results.php?tenpoCode=".$tenpoCode);
        }
        elseif($genreCode!=""){
            header("Location:search_results.php?genreCode=".$genreCode);
        }
        else{
            header("Location:search_results.php");
        }


?>