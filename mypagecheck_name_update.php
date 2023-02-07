<?php
    require_once './helpers/db_helper.php';
    $dbh=get_db_connect();
    $userName=$_POST['nameup'];
    $userId=$_POST['userId'];

    if (isset($_POST['userId'])&&isset($_POST['nameup'])) {
        $sql ="UPDATE puser SET userName = :userName WHERE userId = :userId ";

        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':userName',$userName,PDO::PARAM_STR);
        $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
        $stmt->execute();

        header("Location:mypagecheck.php?userId=".$userId);
        exit;
    }



?>