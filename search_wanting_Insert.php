<?php
#欲しリス登録
    require_once './helpers/db_helper.php';
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

        if($_GET['keyword']!=""){
            $keyword=$_GET['keyword'];
            header("Location:search_results.php?keyword=".$keyword);
        }
        elseif($_GET['tenpoCode']!=""){
            //print("ssss");
            $tenpoCode=$_GET['tenpoCode'];
            header("Location:search_results.php?tenpoCode=".$tenpoCode);
        }
        elseif($_GET['genreCode']!=""){
            //print("ssss");
            $genreCode=$_GET['genreCode'];
            header("Location:search_results.php?genreCode=".$genreCode);
        }
        else{
            //print("aaaa");
            header("Location:search_results.php");
        }

?>