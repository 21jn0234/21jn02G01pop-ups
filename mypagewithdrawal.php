<?php
        require_once 'helpers/db_helper.php';
                                            
        $useId = '';
        $errs = '';

        if(isset($member['userId'])){
            $userId=$member['userId'];
        }
        else{
            $userId=null;
        }

        //$puser_pass=withdrawal_puser_pass($dbh,$pw);

        

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>退会</title> 
    <link href="mypage.css" rel="stylesheet" />
    <script src="./jquery-3.6.0.min.js"></script>
    <script src="./jquery.validate.min.js"></script>
</head>
<body>
    <?php include "header.php" ?>
    <h1>退会</h1>
    <p>［確認事項］<br>
    当アカウントに登録されているデータは全て削除されます。<br>
    削除されたデータは復元することができません。</p><br>

    <p>パスワードを入力し、「退会」ボタンを押してください。</p>
    <p>パスワード</p>

    <form id="withdrawal" method="POST" action="mypagewithdrawal_Update.php">
    <input type="password" name="pass" />
    <?php //エラーメッセージの表示ができてない
    
    if(isset($_GET['bool']) && $_GET['bool']=="FALSE"  && isset($_GET['pass']) && $_GET['pass']==1){
            $errs="パスワードに誤りがあります。";
    }
    elseif(isset($_GET['pass']) && $_GET['pass']==2){
            $errs="パスワードを入力して下さい";
    }
            ?><span style="color:red"><?php print($errs);?></span>
        
    
    
    <br><br>
    <input type="hidden" name="userId" value=<?=$member['userId']?>>

   

    <input type="submit" value="退会">
    </form>

    <!-- <script>
        $(function(){
            $("#withdrawal").validate({
                rules:{
                    pass:{
                        required:true
                    },
                },
                messages:{
                    pass:{
                        required:"パスワードを入力して下さい"
                    },
                },
            });
            $("#withdrawal").css('color','red');
        });
    </script> -->
    


    <hr>
    <div class="my">
    <a href="mypage.php">マイページ</a><br>
    <a href="mypagecheck.php">登録内容の確認・変更</a><br>
    <a href="mypagewithdrawal.php">退会</a><br><br>

    <a href="./logout.php">ログアウト</a>
    </div>



