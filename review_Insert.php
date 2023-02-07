<?php
#レビュー登録
    require_once './helpers/db_helper.php';
        $dbh=get_db_connect();

        $reviewId=review_numbering($dbh);
        $userId=$_POST['userId'];
        $syohinId=$_POST['syohinId'];
        $evaluation=$_POST['evaluation'];
        $comment=$_POST['comment'];

        
        $sql ="INSERT INTO review VALUES(:reviewId,:userId,:syohinId,:evaluation,:comment)";#inset into
    
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':reviewId',$reviewId,PDO::PARAM_STR);
        $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
        $stmt->bindValue(':syohinId',$syohinId,PDO::PARAM_STR);
        $stmt->bindValue(':evaluation',$evaluation,PDO::PARAM_INT);
        $stmt->bindValue(':comment',$comment,PDO::PARAM_STR);
        
        $stmt->execute();
        header("Location:Product_detail.php?syohinId=".$syohinId );

?>