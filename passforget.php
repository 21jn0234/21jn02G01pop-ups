<script src="./jquery-3.6.0.min.js"></script>
<?php
    require_once 'helpers/db_helper.php';
    require_once 'helpers/extra_helper.php';
    
    //require_once './helpers/db_helper_baba.php';
                    
    $errs = [];

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $userId=$_POST['email'];
        $dbh=get_db_connect();

        if($userId==""){
            $errs['email']=" ユーザーIDを入力して下さい。";
        }
        elseif(!filter_var($userId,FILTER_VALIDATE_EMAIL)){
            $errs['email']=" ユーザーID(メールアドレス)の形式に誤りがあります。";
        }
        elseif(!email_exists($dbh,$userId)) {
            $errs['email'] = ' このメールアドレスのアカウントは存在しません。';
        }
        if (empty($errs)) {
            //テストのためメールを飛ばしてパスワード再発行へ
            $forwardDate=date('Y-m-d H:i:s',strtotime('+1 day'));
            $pass=substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz0123456789"), 0, 10);
            $forwardid= openssl_encrypt($userId, 'AES-128-ECB', $pass);
            $forwardid=urlencode($forwardid);
            insert_forgetURL($dbh,$forwardid,$userId,$pass,$forwardDate);
            
            header("Location:mail.php?userId=$forwardid");
            exit;
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <?php include "header.php"?>
    <title>パスワードをお忘れの方</title>
</head>
<body>
    <form action="" method="POST">
        <table id="LoginTable" class="box">
            <tr>
                <h1>
                パスワードをお忘れの方<br>
                </h1>               
            </tr>

            <div id="mail">
                <tr>
                    メールアドレス（登録済みのものに限ります）<br>
                   
                       <input type="text"name="email"/>
                       <span style="color:red"><?= @$errs['email'] ?></span>
                    

                 </tr>
            </div>

            <div id="forgetbtn">
                <tr>
                    
                    <input type="submit" value="送信"/><br><br><br>
                    <input type="button" onclick="location.href='login.php'" value="ログインページ">
                    
                </tr>
            </div>
        </table>
    </form>
</body>
</html>