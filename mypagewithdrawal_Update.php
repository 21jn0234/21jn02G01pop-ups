<?php
//ユーザーの退会処理
require_once './helpers/db_helper.php';
    $dbh=get_db_connect();
    $userId=$_POST['userId'];
    $pw=$_POST['pass'];
    $puser_pass=withdrawal_puser_pass($dbh,$pw);
    #print($puser_pass);
   
session_start();
 
/* 未ログイン状態ならトップへリダイレクト */
// if (!isset($_SESSION['userId'])) {
//   header('Location: login.php');
//   exit;
// }

/* 退会処理 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  /* ログイン状態で、かつ退会ボタンを押した */
  if (isset($_POST['pass'])&&$puser_pass=="TRUE") {

    /* 退会 */
    $sql ="UPDATE puser SET tFlag = 1 WHERE userId = :userId ";
    
    $stmt = $dbh->prepare($sql);
    #$stmt->bindValue(':pw',$pw,PDO::PARAM_STR);
    $stmt->bindValue(':userId',$userId,PDO::PARAM_STR);
    $stmt->execute();
 
    session_destroy(); // セッションを破壊
    
    header('Location:mypagewithdrawal_check.php');
    exit;
    }elseif($puser_pass=="FALSE" && $pw!=""){ ?>
        <!-- <input type="hidden" name="pass_not" value=<//?=$puser_pass?>> -->
        <?php #print($puser_pass ) ?>
        <?php header("Location:mypagewithdrawal.php?bool=$puser_pass&pass=1"); 
        
    }elseif($puser_pass=="FALSE" && empty($pw)){ ?>
        <!-- <input type="hidden" name="pass_not" value=<//?=$puser_pass?>> -->
        <?php #print($puser_pass ) ?>
        <?php header("Location:mypagewithdrawal.php?bool=$puser_pass&pass=2"); 
    }
}
 


     
    // }
        
    // else{
    // $sql ="DELETE FROM puser WHERE pw=:pw";
    
    // $stmt = $dbh->prepare($sql);
    // $stmt->bindValue(':pw',$pw,PDO::PARAM_STR);
    // $stmt->execute();
        

    // header("Location:top.php");
    // }


?>